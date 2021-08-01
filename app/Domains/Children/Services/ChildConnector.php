<?php

declare(strict_types=1);

namespace Domains\Children\Services;

use Domains\Attendants\Models\Attendant;
use Domains\Children\Models\Child;
use Domains\Users\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Parents\ValueObjects\CrmIdValueObject;
use Support\VtigerClient\WSException;

final class ChildConnector extends \Parents\Services\ConnectorService
{
    public function receive(): Collection
    {
        $result = collect([]);

        try {
            $contacts = $this->client->entities?->findMany('Contacts', [
                'type' => 'Child',
                'modifiedtime' => Carbon::now()->subDay()->format('Y-m-d')
            ]);
        } catch (WSException $e) {
            Log::error('Error in getting child data from Vtiger: ' . $e->getMessage());
            app('sentry')->captureException($e);
            $contacts = null;
        }

        if (!$contacts) {
            return $result;
        }

        foreach ($contacts as $contact) {
            $result->push($this->getFilesToCollection($contact));
        }

        return $result;
    }

    /**
     * @param  Child  $child
     * @return Collection
     * @throws WSException
     * @psalm-suppress PossiblyNullReference
     */
    public function send(Child $child): Collection
    {
        if (is_null($child->crmid) || $child->crmid->isNull()) {
            /** @var array<string, string> $result */
            $result = $this->client->entities->createOne('Contacts', $child->toCrmArray());
            $child->crmid = CrmIdValueObject::fromNative($result['id']);
            $child->save();
            return collect($result);
        }
        $contactData = $this->client->entities->findOneByID('Contacts', (string) $child->crmid->toInt());
        if (!$contactData) {
            throw new \DomainException('No data received from Vtiger while updating Children ' . $child->id);
        }
        $result = $this->client->entities->updateOne(
            'Contacts',
            (string) $child->crmid->toInt(),
            $this->getUpdatedArray($contactData, $child)
        );
        return collect($result);
    }

    protected function getUpdatedArray(array $contact, Child $child): array
    {
        $contact['firstname'] = $child->firstname;
        $contact['lastname'] = $child->lastname;
        $contact['middle_name'] = $child->middle_name;
        $contact['phone'] = $child->phone?->toNative();
        $contact['otherphone'] = $child->otherphone?->toNative();
        $contact['birthday'] = $child->birthday;
        $contact['gender'] = $child->gender->value;
        return $contact;
    }

    protected function getFilesToCollection(array $contact): Collection
    {
/*        $contact['files'] = $this->client->invokeOperation('files_retrieve', [
            'id' => $contact['id']
        ]);*/
        return collect($contact);
    }
}

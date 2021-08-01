<?php

declare(strict_types=1);

namespace Domains\Users\Services;

use Domains\Users\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Parents\ValueObjects\CrmIdValueObject;
use Support\VtigerClient\WSException;

final class UserConnector extends \Parents\Services\ConnectorService
{
    public function receive(): Collection
    {
        $result = collect([]);

        try {
            $contacts = $this->client->entities?->findMany('Contacts', [
                'type' => 'Client',
                'modifiedtime' => Carbon::now()->subDay()->format('Y-m-d')
            ]);
        } catch (WSException $e) {
            Log::error('Error in getting users data from Vtiger: ' . $e->getMessage());
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
     * @param  User  $user
     * @return Collection
     * @throws WSException
     * @psalm-suppress PossiblyNullReference
     */
    public function send(User $user): Collection
    {
        if (is_null($user->crmid) || $user->crmid->isNull()) {
            /** @var array<string, string> $result */
            $result = $this->client->entities?->createOne('Contacts', $user->toCrmArray());
            $user->crmid = CrmIdValueObject::fromNative($result['id']);
            $user->save();
            return collect($result);
        }
        $contactData = $this->client->entities?->findOneByID('Contacts', (string) $user->crmid->toInt());
        if (!$contactData) {
            throw new \DomainException('No data received from Vtiger while updating User ' . $user->id);
        }
        $result = $this->client->entities?->updateOne(
            'Contacts',
            (string) $user->crmid->toInt(),
            $this->getUpdatedArray($contactData, $user)
        );
        return collect($result);
    }

    protected function getUpdatedArray(array $contact, User $user): array
    {
        $contact['firstname'] = $user->firstname;
        $contact['lastname'] = $user->lastname;
        $contact['middle_name'] = $user->middle_name;
        $contact['phone'] = $user->phone;
        $contact['otherphone'] = $user->otherphone;
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

<?php

declare(strict_types=1);

namespace Domains\Children\DataTransferObjects;

use Illuminate\Support\Collection;
use Parents\DataTransferObjects\ObjectData;
use Illuminate\Support\Carbon;
use Parents\Enums\GenderEnum;
use Parents\Requests\Request;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\PhoneNumberValueObject;
use Parents\ValueObjects\UrlValueObject;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\Helpers\ImageHelper;

final class ChildData extends ObjectData
{
    public ?int $id;

    public string $firstname;

    public string $lastname;

    public ?string $middle_name;

    public Carbon $birthday;

    public GenderEnum $gender;

    public PhoneNumberValueObject $phone;

    public ?PhoneNumberValueObject $otherphone;

    public CrmIdValueObject $crmid;

    public CrmIdValueObject $assigned_user_id;

    public ?string $file;

    public ?Media $avatar;

    public ?string $avatar_path;

    public UrlValueObject $external_file;

    public array $users;

    public array $documents = [];

    public Carbon $created_at;

    public Carbon $updated_at;

    /**
     * @param  Request  $request
     * @param  string  $prefix
     * @return static
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @psalm-suppress PossiblyInvalidMethodCall
     */
    public static function fromRequest(Request $request, string $prefix = ''): self
    {
        return new self([
            'created_at' => now(),
            'updated_at' => now(),
            'file' => $request->input($prefix . 'file'),
            'external_file' => UrlValueObject::fromNative($request->input($prefix . 'external_file')),
            'crmid' => CrmIdValueObject::fromNative($request->input($prefix . 'crmid')),
            'assigned_user_id' => CrmIdValueObject::fromNative(
                $request->input($prefix . 'assigned_user_id')
            ),
            'avatar_path' => $request->file($prefix . 'imagename')?->path(),
            'otherphone' => $request->input($prefix . 'otherphone') ?
                PhoneNumberValueObject::fromNative($request->input($prefix . 'otherphone')) : null,
            'firstname' => $request->input($prefix . 'firstname'),
            'lastname' => $request->input($prefix . 'lastname'),
            'middle_name' => $request->input($prefix . 'middle_name'),
            'phone' => PhoneNumberValueObject::fromNative($request->input($prefix . 'phone')),
            'birthday' => Carbon::createFromFormat('Y-m-d', $request->input($prefix . 'birthday')),
            'gender' => GenderEnum::fromValue($request->input($prefix . 'gender')),
            'users' => $request->input($prefix . 'users', [])
        ]);
    }

    public static function fromConnector(Collection $data): self
    {
        return new self([
            'created_at' => now(),
            'updated_at' => now(),
            'crmid' => CrmIdValueObject::fromNative($data->get('id')),
            'assigned_user_id' => CrmIdValueObject::fromNative($data->get('assigned_user_id')),
            'otherphone' => $data->get('otherphone') ?
                PhoneNumberValueObject::fromNative($data->get('otherphone')) : null,
            'firstname' => $data->get('firstname'),
            'lastname' => $data->get('lastname'),
            'middle_name' => $data->get('middle_name'),
            'phone' => PhoneNumberValueObject::fromNative($data->get('phone')),
            'birthday' => Carbon::createFromFormat('Y-m-d', $data->get('birthday')),
            'gender' => GenderEnum::fromValue($data->get('gender')),
            'users' => $data->get('contact_id') ? [$data->get('contact_id')] : [],
            'external_file' => ImageHelper::getValueObjectFromArray($data->get('avatar', [])),
            'documents' => ImageHelper::convertDocumentsToValueObject($data->get('images', []))

        ]);
    }
}

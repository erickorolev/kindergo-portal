<?php

declare(strict_types=1);

namespace Domains\Users\DataTransferObjects;

use Domains\Users\Enums\AttendantCategoryEnum;
use Domains\Users\Enums\AttendantStatusEnum;
use Domains\Users\ValueObjects\FullNameValueObject;
use Domains\Users\ValueObjects\PasswordValueObject;
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

final class UserData extends ObjectData
{
    public ?int $id;

    public FullNameValueObject $name;

    public string $email;

    public ?Carbon $email_verified_at;

    public ?PasswordValueObject $password;

    public ?Media $avatar;

    public ?string $avatar_path;

    public string $firstname;

    public array $roles = [];

    public string $lastname;

    public ?string $middle_name;

    public ?string $file;

    public UrlValueObject $external_file;

    public PhoneNumberValueObject $phone;

    public GenderEnum $gender;

    public AttendantCategoryEnum $attendant_category;

    public AttendantStatusEnum $attendant_status;

    public ?Carbon $attendant_hired;

    public ?Carbon $birthday;

    public ?string $mailingzip;

    public ?string $mailingstate;

    public ?string $mailingcountry;

    public ?string $mailingcity;

    public ?string $mailingstreet;

    public ?string $otherzip;

    public ?string $otherstate;

    public ?string $othercountry;

    public ?string $othercity;

    public ?string $otherstreet;

    public ?string $metro_station;

    public ?string $car_model;

    public ?string $car_year;

    public ?string $car_color;

    public ?string $resume;

    public ?string $payment_data;

    public ?PhoneNumberValueObject $otherphone;

    public CrmIdValueObject $crmid;

    public CrmIdValueObject $assigned_user_id;

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
            'name' => FullNameValueObject::fromNative(
                $request->input($prefix . 'firstname'),
                $request->input($prefix . 'lastname'),
                $request->input($prefix . 'middle_name')
            ),
            'email' => $request->input($prefix . 'email'),
            'password' => $request->input($prefix . 'password') ?
                PasswordValueObject::fromNative($request->input($prefix . 'password')) : null,
            'firstname' => $request->input($prefix . 'firstname'),
            'lastname' => $request->input($prefix . 'lastname'),
            'middle_name' => $request->input($prefix . 'middle_name'),
            'phone' => PhoneNumberValueObject::fromNative($request->input($prefix . 'phone')),
            'gender' => GenderEnum::fromValue($request->input($prefix . 'gender', 'Other')),
            'otherphone' => $request->input($prefix . 'otherphone') ?
                PhoneNumberValueObject::fromNative($request->input($prefix . 'otherphone')) : null,
            'attendant_category' => AttendantCategoryEnum::fromValue(
                $request->input($prefix . 'attendant_category', 'Other')
            ),
            'attendant_status' => AttendantStatusEnum::fromValue(
                $request->input($prefix . 'attendant_status', 'Active')
            ),
            'attendant_hired' => $request->input($prefix . 'attendant_hired') ?
                Carbon::createFromFormat('Y-m-d', $request->input($prefix . 'attendant_hired')) :
                null,
            'birthday' => $request->input($prefix . 'birthday') ?
                Carbon::createFromFormat('Y-m-d', $request->input($prefix . 'birthday')) :
                null,
            'mailingzip' => $request->input($prefix . 'mailingzip'),
            'mailingstate' => $request->input($prefix . 'mailingstate'),
            'mailingcountry' => $request->input($prefix . 'mailingcountry'),
            'mailingcity' => $request->input($prefix . 'mailingcity'),
            'mailingstreet' => $request->input($prefix . 'mailingstreet'),
            'otherzip' => $request->input($prefix . 'otherzip'),
            'otherstate' => $request->input($prefix . 'otherstate'),
            'othercountry' => $request->input($prefix . 'othercountry'),
            'othercity' => $request->input($prefix . 'othercity'),
            'otherstreet' => $request->input($prefix . 'otherstreet'),
            'metro_station' => $request->input($prefix . 'metro_station'),
            'car_model' => $request->input($prefix . 'car_model'),
            'car_year' => $request->input($prefix . 'car_year'),
            'car_color' => $request->input($prefix . 'car_color'),
            'resume' => $request->input($prefix . 'resume'),
            'payment_data' => $request->input($prefix . 'payment_data'),
            'created_at' => now(),
            'updated_at' => now(),
            'crmid' => CrmIdValueObject::fromNative($request->input($prefix . 'crmid')),
            'assigned_user_id' => CrmIdValueObject::fromNative(
                $request->input($prefix . 'assigned_user_id')
            ),
            'avatar_path' => $request->file($prefix . 'imagename')?->path(),
            'roles' => $request->has($prefix . 'roles') ? $request->input($prefix . 'roles', []) : [],
            'file' => $request->input($prefix . 'file'),
            'external_file' => UrlValueObject::fromNative($request->input($prefix . 'external_file')),
        ]);
    }

    public static function fromConnector(Collection $data): self
    {
        return new self([
            'name' => FullNameValueObject::fromNative(
                $data->get('firstname'),
                $data->get('lastname'),
                $data->get('middle_name')
            ),
            'email' => $data->get('email'),
            'password' => PasswordValueObject::fromNative($data->get('password')),
            'firstname' => $data->get('firstname'),
            'lastname' => $data->get('lastname'),
            'middle_name' => $data->get('middle_name'),
            'phone' => PhoneNumberValueObject::fromNative($data->get('phone')),
            'gender' => GenderEnum::fromValue($data->get('attendant_gender', 'Other')),
            'otherphone' => $data->get('otherphone') ?
                PhoneNumberValueObject::fromNative($data->get('otherphone')) : null,
            'attendant_category' => AttendantCategoryEnum::fromValue(
                $data->get('attendant_category', 'Other')
            ),
            'attendant_status' => AttendantStatusEnum::fromValue(
                $data->get('attendant_status', 'Active')
            ),
            'attendant_hired' => $data->get('attendant_hired') ?
                Carbon::createFromFormat('Y-m-d', $data->get('attendant_hired')) :
                null,
            'birthday' => $data->get('birthday') ?
                Carbon::createFromFormat('Y-m-d', $data->get('birthday')) :
                null,
            'mailingzip' => $data->get('mailingzip'),
            'mailingstate' => $data->get('mailingstate'),
            'mailingcountry' => $data->get('mailingcountry'),
            'mailingcity' => $data->get('mailingcity'),
            'mailingstreet' => $data->get('mailingstreet'),
            'otherzip' => $data->get('otherzip'),
            'otherstate' => $data->get('otherstate'),
            'othercountry' => $data->get('othercountry'),
            'othercity' => $data->get('othercity'),
            'otherstreet' => $data->get('otherstreet'),
            'metro_station' => $data->get('metro_station'),
            'car_model' => $data->get('car_model'),
            'car_year' => $data->get('car_year'),
            'car_color' => $data->get('car_color'),
            'resume' => $data->get('resume'),
            'payment_data' => $data->get('payment_data'),
            'created_at' => now(),
            'updated_at' => now(),
            'crmid' => CrmIdValueObject::fromNative($data->get('id')),
            'assigned_user_id' => CrmIdValueObject::fromNative($data->get('assigned_user_id')),
            'roles' => [],
            'external_file' => ImageHelper::getValueObjectFromArray($data->get('avatar', [])),
            'documents' => ImageHelper::convertDocumentsToValueObject($data->get('images', []))
        ]);
    }
}

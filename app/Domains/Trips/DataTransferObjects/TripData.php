<?php

declare(strict_types=1);

namespace Domains\Trips\DataTransferObjects;

use Domains\Children\Actions\GetChildrenIdsFromArrayAction;
use Domains\Trips\Enums\TripStatusEnum;
use Domains\Users\Actions\GetClearUserIdAction;
use Illuminate\Support\Collection;
use Parents\DataTransferObjects\ObjectData;
use Illuminate\Support\Carbon;
use Parents\Requests\Request;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\MoneyValueObject;
use Parents\ValueObjects\TimeValueObject;
use Parents\ValueObjects\UrlValueObject;
use Support\Helpers\ImageHelper;

final class TripData extends ObjectData
{
    public ?int $id;

    public string $name;

    public string $where_address;

    public Carbon $date;

    public TimeValueObject $time;

    public int $childrens;

    public int $duration;

    public float $distance;

    public TripStatusEnum $status;

    public ?int $attendant_id;

    public int $scheduled_wait_where;

    public int $scheduled_wait_from;

    public ?string $description;

    public ?string $parking_info;

    public ?int $not_scheduled_wait_where;

    public ?int $not_scheduled_wait_from;

    public ?MoneyValueObject $parking_cost;

    public ?MoneyValueObject $attendant_income;

    public ?int $user_id;

    public CrmIdValueObject $crmid;

    public CrmIdValueObject $assigned_user_id;

    public CrmIdValueObject $cf_timetable_id;

    public array $files = [];

    public string $file = '';

    public array $external_files = [];

    public array $documents = [];

    public array $children = [];

    public Carbon $created_at;

    public Carbon $updated_at;

    public static function fromRequest(Request $request, string $prefix = ''): self
    {
        $user_id = GetClearUserIdAction::run($request->input($prefix . 'user_id'));
        $children = GetChildrenIdsFromArrayAction::run($request->input($prefix . 'children', []));
        return new self([
            'created_at' => now(),
            'updated_at' => now(),
            'name' => $request->input($prefix . 'name'),
            'where_address' => $request->input($prefix . 'where_address'),
            'description' => $request->input($prefix . 'description'),
            'parking_info' => $request->input($prefix . 'parking_info'),
            'date' => Carbon::createFromFormat('Y-m-d', $request->input($prefix . 'date')),
            'time' => TimeValueObject::fromNative($request->input($prefix . 'time')),
            'childrens' => (int) $request->input($prefix . 'childrens'),
            'duration' => (int) $request->input($prefix . 'duration'),
            'distance' => (float) $request->input($prefix . 'distance'),
            'status' => TripStatusEnum::fromValue($request->input($prefix . 'status')),
            'scheduled_wait_where' => (int) $request->input($prefix . 'scheduled_wait_where'),
            'scheduled_wait_from' => (int) $request->input($prefix . 'scheduled_wait_from'),
            'not_scheduled_wait_where' => $request->input($prefix . 'not_scheduled_wait_where') ?
                (int) $request->input($prefix . 'not_scheduled_wait_where') : null,
            'not_scheduled_wait_from' => $request->input($prefix . 'not_scheduled_wait_from') ?
                (int) $request->input($prefix . 'not_scheduled_wait_from') : null,
            'parking_cost' => $request->input($prefix . 'parking_cost') ?
                MoneyValueObject::fromNative($request->input($prefix . 'parking_cost')) : null,
            'attendant_income' => $request->input($prefix . 'attendant_income') ?
                MoneyValueObject::fromNative($request->input($prefix . 'attendant_income')) : null,
            'user_id' => $user_id,
            'crmid' => CrmIdValueObject::fromNative($request->input($prefix . 'crmid')),
            'cf_timetable_id' => CrmIdValueObject::fromNative($request->input($prefix . 'cf_timetable_id')),
            'assigned_user_id' => CrmIdValueObject::fromNative(
                $request->input($prefix . 'assigned_user_id')
            ),
            'file' => $request->input($prefix . 'file', ''),
            'documents' => $request->file('document'),
            'external_files' => ImageHelper::convertToUrlValues($request->input($prefix . 'external_file', [])),
            'children' => $children->toArray()
        ]);
    }

    public static function fromConnector(Collection $data): self
    {
        $user_id = GetClearUserIdAction::run($data->get('trips_contact'));
        $children = GetChildrenIdsFromArrayAction::run($data->get('children', []));
        return new self([
            'created_at' => now(),
            'updated_at' => now(),
            'name' => $data->get('name'),
            'where_address' => $data->get('where_address'),
            'description' => $data->get('description'),
            'parking_info' => $data->get('parking_info'),
            'date' => Carbon::createFromFormat('Y-m-d', $data->get('date')),
            'time' => TimeValueObject::fromNative($data->get('time')),
            'childrens' => (int) $data->get('childrens'),
            'duration' => (int) $data->get('duration'),
            'distance' => (float) $data->get('distance'),
            'status' => TripStatusEnum::fromValue($data->get('status')),
            'scheduled_wait_where' => (int) $data->get('scheduled_wait_where'),
            'scheduled_wait_from' => (int) $data->get('scheduled_wait_from'),
            'not_scheduled_wait_where' => $data->get('not_scheduled_wait_where') ?
                (int) $data->get('not_scheduled_wait_where') : null,
            'not_scheduled_wait_from' => $data->get('not_scheduled_wait_from') ?
                (int) $data->get('not_scheduled_wait_from') : null,
            'parking_cost' => MoneyValueObject::fromNative($data->get('parking_cost')),
            'attendant_income' => $data->get('attendant_income') ?
                MoneyValueObject::fromNative($data->get('attendant_income')) : null,
            'user_id' => $user_id,
            'crmid' => CrmIdValueObject::fromNative($data->get('id')),
            'cf_timetable_id' => CrmIdValueObject::fromNative($data->get('cf_timetable_id')),
            'assigned_user_id' => CrmIdValueObject::fromNative($data->get('assigned_user_id')),
            'children' => $children->toArray(),
            'external_file' => UrlValueObject::fromNative(null),
            'documents' => ImageHelper::convertDocumentsToValueObject($data->get('images', []))
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Domains\Trips\Models;

use Domains\Children\Models\Child;
use Domains\Trips\Enums\TripStatusEnum;
use Domains\Trips\Factories\TripFactory;
use Domains\Users\Models\User;
use Illuminate\Support\Collection;
use Parents\Casts\CrmIdValueObjectCast;
use Parents\Casts\MoneyValueCast;
use Parents\Casts\TimeValueObjectCast;
use Parents\Models\Model;
use Parents\Scopes\UserScope;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Units\Filterings\Scopes\Searchable;

/**
 * Class Trip
 * @package Domains\Trips\Models
 * @property int $id
 * @property string $name Откуда
 * @property string $where_address Куда
 * @property \Illuminate\Support\Carbon $date Дата отправления
 * @property \Parents\ValueObjects\TimeValueObject|null $time Время отправления
 * @property int $childrens Количество детей
 * @property int $duration Длительность маршрута
 * @property float $distance Длительность маршрута в км
 * @property \Domains\Trips\Enums\TripStatusEnum $status Статус
 * @property int|null $user_id Клиент
 * @property int $timetable_id Расписание
 * @property int $scheduled_wait_where Запланированное время ожидания в точке Куда
 * @property int|null $not_scheduled_wait_where Запланированное время ожидания в точке Куда
 * @property int $scheduled_wait_from Незапланированное время ожидания в точке куда
 * @property int|null $not_scheduled_wait_from Незапланированное время ожидания в точке Откуда
 * @property \Parents\ValueObjects\MoneyValueObject|null $parking_cost Стоимость парковки
 * @property \Parents\ValueObjects\MoneyValueObject|null $attendant_income Доход сопровождающего
 * @property \Parents\ValueObjects\CrmIdValueObject|null $crmid ID in Vtiger
 * @property \Parents\ValueObjects\CrmIdValueObject $assigned_user_id Owner in Vtiger
 * @property \Parents\ValueObjects\CrmIdValueObject $cf_timetable_id Timetable in Vtiger
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Children\Models\Child[] $children
 * @property-read int|null $children_count
 * @property-read \Domains\Timetables\Models\Timetable $timetable
 * @property-read \Domains\Users\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip searchLatestPaginated(string $search, string $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereAttendantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereChildrens($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCrmid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereParkingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereScheduledWaitFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereScheduledWaitWhere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTimetableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereWhereAddress($value)
 */
final class Trip extends Model implements HasMedia
{
    use Searchable;
    use InteractsWithMedia;

    public const RESOURCE_NAME = 'trips';

    public const DOMAIN_NAME = 'Trips';

    protected $fillable = [
        'name',
        'where_address',
        'date',
        'time',
        'childrens',
        'duration',
        'distance',
        'status',
        'timetable_id',
        'scheduled_wait_where',
        'scheduled_wait_from',
        'not_scheduled_wait_where',
        'not_scheduled_wait_from',
        'attendant_income',
        'parking_cost',
        'user_id',
        'crmid',
        'assigned_user_id',
        'cf_timetable_id',
    ];

    protected array $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
        'status' => TripStatusEnum::class,
        'childrens' => 'int',
        'parking_cost' => MoneyValueCast::class,
        'attendant_income' => MoneyValueCast::class,
        'time' => TimeValueObjectCast::class,
        'scheduled_wait_from' => 'int',
        'scheduled_wait_where' => 'int',
        'crmid' => CrmIdValueObjectCast::class,
        'assigned_user_id' => CrmIdValueObjectCast::class,
        'duration' => 'int',
        'distance' => 'float',
        'cf_timetable_id' => CrmIdValueObjectCast::class
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope());
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Child::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getDocumentsAttribute(): ?Collection
    {
        return $this->getMedia('documents');
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['time'] = $this->time?->toNative();
        $data['crmid'] = $this->crmid?->toNative();
        $data['assigned_user_id'] = $this->assigned_user_id?->toNative();
        $data['cf_timetable_id'] = $this->cf_timetable_id?->toNative();
        $data['parking_cost'] = $this->parking_cost?->toFloat();
        $data['attendant_income'] = $this->attendant_income?->toFloat();
        $data['status'] = $this->status->value;
        return $data;
    }

    public function toFullArray(): array
    {
        $data = parent::toArray();
        $data['time'] = $this->time;
        $data['crmid'] = $this->crmid;
        $data['assigned_user_id'] = $this->assigned_user_id;
        $data['cf_timetable_id'] = $this->cf_timetable_id;
        $data['parking_cost'] = $this->parking_cost;
        $data['attendant_income'] = $this->attendant_income;
        $data['status'] = $this->status;
        return $data;
    }

    protected static function newFactory(): TripFactory
    {
        return TripFactory::new();
    }
}

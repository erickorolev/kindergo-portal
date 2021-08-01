<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Domains\Authorization\Models{
/**
 * Class Permission
 *
 * @package Domains\Authorization\Models
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Users\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	final class Permission extends \Eloquent {}
}

namespace Domains\Authorization\Models{
/**
 * Class Role
 *
 * @package Domains\Authorization\Models
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Users\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	final class Role extends \Eloquent {}
}

namespace Domains\Children\Models{
/**
 * Class Child
 *
 * @package Domains\Children\Models
 * @property int $id
 * @property string $firstname Имя
 * @property string $lastname Фамилия
 * @property string|null $middle_name Отчество
 * @property \Illuminate\Support\Carbon $birthday Дата рождения
 * @property \Parents\Enums\GenderEnum $gender Пол
 * @property \Parents\ValueObjects\PhoneNumberValueObject|null $phone Телефон
 * @property string|null $imagename Фотография
 * @property \Parents\ValueObjects\PhoneNumberValueObject|null $otherphone Другой телефон
 * @property \Parents\ValueObjects\CrmIdValueObject|null $crmid ID in Vtiger
 * @property \Parents\ValueObjects\CrmIdValueObject|null $assigned_user_id Owner in Vtiger
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Media|null $avatar
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Timetables\Models\Timetable[] $timetables
 * @property-read int|null $timetables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Trips\Models\Trip[] $trips
 * @property-read int|null $trips_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Users\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Child newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Child newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Child query()
 * @method static \Illuminate\Database\Eloquent\Builder|Child search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Child searchLatestPaginated(string $search, string $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereCrmid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereImagename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereOtherphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereUpdatedAt($value)
 */
	final class Child extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace Domains\Payments\Models{
/**
 * Class Payment
 *
 * @package Domains\Payments\Models
 * @property int $id
 * @property \Illuminate\Support\Carbon $pay_date Дата платежа
 * @property \Domains\Payments\Enums\TypePaymentEnum $type_payment Вид оплаты
 * @property \Parents\ValueObjects\MoneyValueObject|null $amount Сумма в копейках
 * @property \Domains\Payments\Enums\SpStatusEnum $spstatus Статус
 * @property int $user_id Контакт
 * @property \Parents\ValueObjects\CrmIdValueObject|null $crmid ID in Vtiger
 * @property \Parents\ValueObjects\CrmIdValueObject $assigned_user_id ID in Vtiger
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Domains\Users\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment searchLatestPaginated(string $search, string $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCrmid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSpstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTypePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 */
	final class Payment extends \Eloquent {}
}

namespace Domains\Trips\Models{
/**
 * Class Trip
 *
 * @package Domains\Trips\Models
 * @property int $id
 * @property string $name Откуда
 * @property string $where_address Куда
 * @property \Illuminate\Support\Carbon $date Дата отправления
 * @property \Parents\ValueObjects\TimeValueObject|null $time Время отправления
 * @property int $childrens Количество детей
 * @property \Domains\Trips\Enums\TripStatusEnum $status Статус
 * @property int|null $attendant_id Сопровождающий
 * @property int|null $user_id Клиент
 * @property int $timetable_id Расписание
 * @property int $scheduled_wait_where Незапланированное время ожидания в точке Куда
 * @property int $scheduled_wait_from Незапланированное время ожидания в точке Откуда
 * @property \Parents\ValueObjects\MoneyValueObject|null $parking_cost Стоимость парковки
 * @property \Parents\ValueObjects\CrmIdValueObject|null $crmid ID in Vtiger
 * @property \Parents\ValueObjects\CrmIdValueObject $assigned_user_id Owner in Vtiger
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Domains\Attendants\Models\Attendant|null $attendant
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
	final class Trip extends \Eloquent {}
}

namespace Domains\Users\Models{
/**
 * Domains\Users\Models\User
 *
 * @property int $id
 * @property \Domains\Users\ValueObjects\FullNameValueObject $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Children\Models\Child[] $children
 * @property-read int|null $children_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Media|null $avatar
 * @property-read string $profile_photo_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Payments\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Domains\Users\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|User searchLatestPaginated(string $search, $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	final class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}


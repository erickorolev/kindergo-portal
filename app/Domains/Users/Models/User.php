<?php

declare(strict_types=1);

namespace Domains\Users\Models;

use Domains\Authorization\Models\Role;
use Domains\Children\Models\Child;
use Domains\Payments\Models\Payment;
use Domains\Users\Casts\EmailValueObjectCast;
use Domains\Users\Casts\FullNameCast;
use Domains\Users\Casts\PhoneValueObjectCast;
use Domains\Users\Enums\AttendantCategoryEnum;
use Domains\Users\Enums\AttendantGenderEnum;
use Domains\Users\Enums\AttendantStatusEnum;
use Domains\Users\Factories\UserFactory;
use Domains\Users\ValueObjects\FullNameValueObject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Parents\Casts\CrmIdValueObjectCast;
use Parents\Enums\GenderEnum;
use Parents\ValueObjects\CrmIdValueObject;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Units\Filterings\Scopes\Searchable;

/**
 * Class User
 *
 * @package Domains\Users\Models
 * @property int $id
 * @property \Domains\Users\ValueObjects\FullNameValueObject $name Отображаемое имя контакта
 * @property string $email Адрес электронной почты
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property int|null $current_team_id
 * @property string|null $imagename Фотография
 * @property string|null $profile_photo_path Фотография Профиля
 * @property string $firstname Имя
 * @property string $lastname Фамилия
 * @property string|null $middle_name Отчество
 * @property \Parents\ValueObjects\PhoneNumberValueObject|null $phone Телефон
 * @property GenderEnum $gender Пол сопровождающего
 * @property \Domains\Users\Enums\AttendantCategoryEnum $attendant_category
 * @property \Domains\Users\Enums\AttendantStatusEnum $attendant_status
 * @property \Illuminate\Support\Carbon|null $attendant_hired
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string|null $mailingzip
 * @property string|null $mailingstate
 * @property string|null $mailingcountry
 * @property string|null $mailingcity
 * @property string|null $mailingstreet
 * @property string|null $otherzip
 * @property string|null $otherstate
 * @property string|null $othercountry
 * @property string|null $othercity
 * @property string|null $otherstreet
 * @property string|null $metro_station
 * @property string|null $car_model
 * @property string|null $car_year
 * @property string|null $car_color
 * @property string|null $resume
 * @property string|null $payment_data
 * @property \Parents\ValueObjects\PhoneNumberValueObject|null $otherphone Другой телефон
 * @property \Parents\ValueObjects\CrmIdValueObject $crmid ID in Vtiger
 * @property \Parents\ValueObjects\CrmIdValueObject $assigned_user_id Owner in Vtiger
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domains\Timetables\Models\Timetable[] $timetables
 * @property-read int|null $timetables_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|User searchLatestPaginated(string $search, string $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAttendantGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCrmid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImagename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtherphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
final class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasRoles;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;
    use InteractsWithMedia;

    public const DOMAIN_NAME = 'Users';

    public const RESOURCE_NAME = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname',
        'middle_name',
        'phone',
        'otherphone',
        'gender',
        'attendant_category',
        'attendant_status',
        'attendant_hired',
        'birthday',
        'mailingzip',
        'mailingstate',
        'mailingcountry',
        'mailingcity',
        'mailingstreet',
        'otherzip',
        'otherstate',
        'othercountry',
        'othercity',
        'otherstreet',
        'metro_station',
        'car_model',
        'car_year',
        'car_color',
        'resume',
        'payment_data',
        'crmid',
        'assigned_user_id',
    ];

    protected array $searchableFields = ['*'];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => GenderEnum::class,
        'name' => FullNameCast::class,
        'phone' => PhoneValueObjectCast::class,
        'otherphone' => PhoneValueObjectCast::class,
        'crmid' => CrmIdValueObjectCast::class,
        'assigned_user_id' => CrmIdValueObjectCast::class,
        'attendant_hired' => 'date',
        'birthday' => 'date',
        'attendant_category' => AttendantCategoryEnum::class,
        'attendant_status' => AttendantStatusEnum::class
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            /** @var string $registrationRole */
            $registrationRole = config('panel.registration_default_role', 'client');
            /** @var ?Role $role */
            $role = Role::whereName($registrationRole)->first();
            if (!$role) {
                return;
            }
            /** @var string $roleName */
            $roleName = $role->name;
            if (!$user->hasRole($roleName)) {
                $user->assignRole($role);
            }
        });
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Child::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getAvatarAttribute(): ?Media
    {
        /** @var ?Media $file */
        $file = $this->getMedia('avatar')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['phone'] = $this->phone?->toNative();
        $data['otherphone'] = $this->otherphone?->toNative();
        $data['name'] = $this->name->toNative();
        $data['gender'] = $this->gender->value;
        $data['crmid'] = $this->crmid?->toNative();
        $data['attendant_category'] = $this->attendant_category->value;
        $data['attendant_status'] = $this->attendant_status?->value;
        $data['assigned_user_id'] = $this->assigned_user_id?->toNative();
        return $data;
    }

    public function toFullArray(): array
    {
        $data = parent::toArray();
        $data['phone'] = $this->phone;
        $data['otherphone'] = $this->otherphone;
        $data['name'] = $this->name;
        $data['attendant_hired'] = $this->attendant_hired;
        $data['birthday'] = $this->birthday;
        $data['gender'] = $this->gender;
        $data['attendant_category'] = $this->attendant_category;
        $data['attendant_status'] = $this->attendant_status;
        $data['email_verified_at'] = $this->email_verified_at;
        $data['crmid'] = $this->crmid;
        $data['assigned_user_id'] = $this->assigned_user_id;
        $data['created_at'] = $this->created_at ?? now();
        $data['updated_at'] = $this->updated_at ?? now();
        return $data;
    }

    public function toCrmArray(): array
    {
        $data = $this->toArray();
        $data['type'] = 'Client';
        unset(
            $data['crmid'],
            $data['id'],
            $data['created_at'],
            $data['updated_at'],
            $data['email_verified_at'],
            $data['avatar'],
            $data['avatar_path'],
        );
        return $data;
    }
}

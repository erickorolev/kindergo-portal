<?php

declare(strict_types=1);

namespace Domains\Children\Models;

use Domains\Trips\Models\Trip;
use Domains\Users\Casts\PhoneValueObjectCast;
use Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Parents\Casts\CrmIdValueObjectCast;
use Parents\Enums\GenderEnum;
use Parents\Models\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Units\Filterings\Scopes\Searchable;

/**
 * Class Child
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
final class Child extends Model implements HasMedia
{
    use Searchable;
    use InteractsWithMedia;

    public const RESOURCE_NAME = 'children';

    public const DOMAIN_NAME = 'Children';

    protected $fillable = [
        'firstname',
        'lastname',
        'middle_name',
        'birthday',
        'gender',
        'phone',
        'imagename',
        'otherphone',
        'crmid',
        'assigned_user_id'
    ];

    protected array $searchableFields = ['*'];

    protected $casts = [
        'birthday' => 'date',
        'gender' => GenderEnum::class,
        'crmid' => CrmIdValueObjectCast::class,
        'assigned_user_id' => CrmIdValueObjectCast::class,
        'phone' => PhoneValueObjectCast::class,
        'otherphone' => PhoneValueObjectCast::class,
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function trips(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Trip::class);
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

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['phone'] = $this->phone?->toNative();
        $data['otherphone'] = $this->otherphone?->toNative();
        $data['gender'] = $this->gender->value;
        $data['crmid'] = $this->crmid?->toNative();
        $data['assigned_user_id'] = $this->assigned_user_id?->toNative();
        return $data;
    }

    public function toFullArray(): array
    {
        $data = parent::toArray();
        $data['phone'] = $this->phone;
        $data['otherphone'] = $this->otherphone;
        $data['gender'] = $this->gender;
        $data['crmid'] = $this->crmid;
        $data['assigned_user_id'] = $this->assigned_user_id;
        $data['created_at'] = $this->created_at ?? now();
        $data['updated_at'] = $this->updated_at ?? now();
        return $data;
    }

    public function toCrmArray(): array
    {
        $data = $this->toArray();
        $data['type'] = 'Child';
        unset(
            $data['crmid'],
            $data['id'],
            $data['created_at'],
            $data['updated_at'],
            $data['imagename'],
        );
        $avatar = $this->avatar;
        if ($avatar) {
            $filename = $avatar->file_name;
            if ($filename == 'avatar.php') {
                $filename = 'avatar.png';
            }
            $data['attachments'] = array(
                'imagename' => [
                    'name' => $filename,
                    'type' => $avatar->mime_type,
                    'size' => $avatar->size,
                    'content' => base64_encode(file_get_contents($avatar->getPath()))
                ]
            );
        }
        return $data;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        /** @var ?User $authUser */
/*        $authUser = Auth::user();
        if ($authUser?->hasExactRoles(['client'])) {
            static::addGlobalScope('users', function (Builder $builder) {
                $builder->whereHas('users', function (Builder $q) {
                    $q->where('child_user.user_id', Auth::id());
                });
            });
        }*/
    }
}

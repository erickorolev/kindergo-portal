<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Models;

/**
 * Class TemporaryFile
 * @package Domains\TemporaryFile\Models
 * @property int $id
 * @property string $folder
 * @property string $filename
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFile whereUpdatedAt($value)
 */
final class TemporaryFile extends \Illuminate\Database\Eloquent\Model
{

    protected $fillable = ['filename', 'folder'];
}

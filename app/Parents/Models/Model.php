<?php

declare(strict_types=1);

namespace Parents\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Pluralizer;
use Parents\Traits\HashIdTrait;
use Parents\Traits\HasResourceKeyTrait;
use Parents\Factories\Factory;

abstract class Model extends LaravelModel
{
    use HasFactory;
    use SoftDeletes;
    use HasResourceKeyTrait;
    use HashIdTrait;

    protected const DOMAIN_NAME = null;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): \Parents\Factories\Factory
    {
        /** @psalm-suppress UnsafeInstantiation */
        $reflect = new \ReflectionClass(new static());
        $resourceKey = Pluralizer::plural($reflect->getShortName());
        if (defined('static::DOMAIN_NAME') && static::DOMAIN_NAME) {
            /** @var string $resourceKey */
            $resourceKey = static::DOMAIN_NAME;
        }
        $namespace = '\Domains\\' . $resourceKey . '\Factories\\' . $reflect->getShortName() . 'Factory';
        /** @var Factory $factory */
        $factory = call_user_func(array($namespace, 'new'));
        return $factory;
    }
}

<?php

namespace Parents\Traits;

use Illuminate\Support\Pluralizer;
use ReflectionClass;

/**
 * Class HasResourceKeyTrait
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
trait HasResourceKeyTrait
{

    /**
     * Returns the type for JSON API Serializer.
     * Can be overwritten with the protected $resourceKey in respective model class
     */
    public function getResourceKey(): string
    {
        if (isset($this->resourceKey)) {
            /** @var string $resourceKey */
            $resourceKey = $this->resourceKey;
        } else {
            $reflect = new ReflectionClass($this);
            /** @var string $resourceKey */
            $resourceKey = strtolower(Pluralizer::plural($reflect->getShortName()));
        }

        return $resourceKey;
    }
}

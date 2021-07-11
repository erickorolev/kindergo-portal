<?php

namespace Parents\Traits;

trait SerializeDateTrait
{
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}

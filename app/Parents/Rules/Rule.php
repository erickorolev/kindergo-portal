<?php

declare(strict_types=1);

namespace Parents\Rules;

use Illuminate\Contracts\Validation\Rule as BaseRule;

abstract class Rule implements BaseRule
{

    /**
     * Array of supporting parameters.
     *
     **/
    protected array $parameters;


    /**
     * Constructor.
     *
     **/
    public function __construct()
    {
        $this->parameters = func_get_args();
    }


    /**
     * Retrieve the appropriate, localized validation message
     * or fall back to the given default.
     *
     **/
    public function getLocalizedErrorMessage(string $key, string $default): ?string
    {
        /** @var ?string $result */
        $result = trans("validation.$key") === "validation.$key" ? $default : trans("validation.$key");
        return $result;
    }
}

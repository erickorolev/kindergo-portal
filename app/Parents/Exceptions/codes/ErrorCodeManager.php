<?php

declare(strict_types=1);

namespace Parents\Exceptions\codes;

use Parents\Exceptions\InternalErrorException;
use Exception;
use ReflectionClass;

/**
 * Class ErrorCodeManager
 *
 */
class ErrorCodeManager
{
    /**
     * @param array $error
     *
     * @return int
     */
    public static function getCode(array $error): int
    {
        /** @var int $result */
        $result = self::getKeyFromArray($error, 'code', 0);
        return $result;
    }

    /**
     * @param array $error
     *
     * @return int|string
     */
    public static function getTitle(array $error): int | string
    {
        return self::getKeyFromArray($error, 'title', '');
    }

    /**
     * @param array $error
     *
     * @return int|string
     */
    public static function getDescription(array $error): int | string
    {
        return self::getKeyFromArray($error, 'description', '');
    }

    /**
     * Returns the value for a given key in the array or a default value
     *
     * @param array $error
     * @param       $key
     * @param       $default
     *
     * @return int|string
     */
    private static function getKeyFromArray(array $error, string $key, int | string $default): int | string
    {
        /** @var int|string $result */
        $result = isset($error[$key]) ? $error[$key] : $default;
        return $result;
    }

    /**
     * Returns all "defined" CodeTables
     *
     * @return array
     */
    public static function getCodeTables(): array
    {
        $codeTables = [
            ApplicationErrorCodesTable::class,
            CustomErrorCodesTable::class,
        ];

        return $codeTables;
    }

    /**
     * Get all arrays for this one error code table
     *
     * @param $codeTable
     *
     * @return array
     * @throws InternalErrorException
     * @throws \ReflectionException
     * @psalm-suppress InvalidStringClass
     */
    public static function getErrorsForCodeTable(string $codeTable): array
    {
        try {
            $class = new $codeTable();
        } catch (Exception $exception) {
            throw new InternalErrorException();
        }

        // now we need to get all errors (i.e., constants) from this class!
        $reflectionClass = new ReflectionClass($class);
        $constants = $reflectionClass->getConstants();

        return $constants;
    }

    /**
     * Get all errors across all defined error code tables
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getErrorsForCodeTables(): array
    {
        $tables = self::getCodeTables();

        $result = [];
        /** @var string $table */
        foreach ($tables as $table) {
            $errors = self::getErrorsForCodeTable($table);
            $result = array_merge($result, $errors);
        }

        return $result;
    }
}

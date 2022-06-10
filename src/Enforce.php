<?php

namespace Squirrel\Types;

use Squirrel\Debug\Debug;
use TypeError;

final class Enforce
{
    /**
     * @pure
     * @throws TypeError
     */
    public static function asBool(mixed $value): bool
    {
        if (\is_bool($value)) {
            return $value;
        }

        throw new TypeError('Value does not contain bool: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function asInt(mixed $value): int
    {
        if (\is_int($value)) {
            return $value;
        }

        throw new TypeError('Value does not contain int: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function asFloat(mixed $value): float
    {
        if (
            \is_int($value)
            || \is_float($value)
        ) {
            return $value;
        }

        throw new TypeError('Value does not contain float or int: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function asString(mixed $value): string
    {
        if (
            \is_string($value)
        ) {
            return $value;
        }

        throw new TypeError('Value does not contain string: ' . Debug::sanitizeData($value));
    }
}

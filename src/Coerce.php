<?php

namespace Squirrel\Types;

use Squirrel\Debug\Debug;
use Stringable;
use TypeError;

final class Coerce
{
    /**
     * @pure
     * @throws TypeError
     */
    public static function toBool(mixed $value, bool $allowEmptyString = false, bool $allowFloat = false): bool
    {
        if (\is_bool($value)) {
            return $value;
        }

        if (\is_string($value)) {
            return self::stringToBool($value, allowEmptyString: $allowEmptyString);
        }

        if (\is_int($value)) {
            return self::intToBool($value);
        }

        if (\is_float($value) && $allowFloat === true) {
            return self::floatToBool($value);
        }

        throw new TypeError('Only 0 and 1' . ( $allowEmptyString ? ' and \'\'' : '' ) . ' are alternative coerceable values for a boolean, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function toInt(mixed $value, bool $allowBool = false): int
    {
        if (\is_int($value)) {
            return $value;
        }

        if (\is_bool($value) && $allowBool === true) {
            return $value === true ? 1 : 0;
        }

        if (\is_float($value)) {
            return self::floatToInt($value);
        }

        if (\is_string($value)) {
            return self::stringToInt($value);
        }

        throw new TypeError('Only ' . ( $allowBool ? 'booleans, ' : '' ) . 'numeric strings and floats with no fractional part are alternative coerceable values for an integer, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function toFloat(mixed $value, bool $allowBool = false): float
    {
        if (\is_int($value) || \is_float($value)) {
            return $value;
        }

        if (\is_bool($value) && $allowBool === true) {
            return $value === true ? 1 : 0;
        }

        if (\is_string($value)) {
            return self::stringToFloat($value);
        }

        throw new TypeError('Only ' . ( $allowBool ? 'booleans and ' : '' ) . 'numeric strings are alternative coerceable values for a float, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function toString(mixed $value, bool $allowBool = false, bool $allowStringable = false): string
    {
        if (\is_string($value)) {
            return $value;
        }

        if (\is_int($value) || \is_float($value)) {
            return \strval($value);
        }

        if (\is_bool($value) && $allowBool === true) {
            return $value === true ? '1' : '0';
        }

        if ($value instanceof Stringable && $allowStringable === true) {
            return $value->__toString();
        }

        throw new TypeError('Only ' . ( $allowBool ? 'booleans, ' : '' ) . ( $allowStringable ? 'Stringable, ' : '' ) . 'integers and floats are alternative coerceable values for a string, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function stringToBool(string $value, bool $allowEmptyString = false): bool
    {
        if (Coerceable::stringToBool($value, allowEmptyString: $allowEmptyString)) {
            return $value === '1';
        }

        throw new TypeError('Only 0 and 1' . ( $allowEmptyString ? ' and \'\'' : '' ) . ' are alternative coerceable values for a boolean, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     */
    public static function boolToString(bool $value): string
    {
        return $value === true ? '1' : '0';
    }

    /**
     * @pure
     */
    public static function intToString(int $value): string
    {
        return \strval($value);
    }

    /**
     * @pure
     */
    public static function floatToString(int|float $value): string
    {
        return \strval($value);
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function intToBool(int $value): bool
    {
        return match($value) {
            0 => false,
            1 => true,
            default => throw new TypeError('Only 0 and 1 can be coerced from an integer to a boolean, given value: ' . Debug::sanitizeData($value)),
        };
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function floatToBool(float $value): bool
    {
        if (Coerceable::floatToBool($value)) {
            return \abs(1.0 - $value) < PHP_FLOAT_EPSILON;
        }

        throw new TypeError('Only 0 and 1 can be coerced from a float to a boolean, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function floatToInt(float $value): int
    {
        if (Coerceable::floatToInt($value)) {
            return \intval($value);
        }

        throw new TypeError('Only numbers with no fractional part can be coerced from a float to an integer, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function stringToInt(string $value): int
    {
        if (Coerceable::stringToInt($value)) {
            return \intval($value);
        }

        throw new TypeError('Only numbers with no fractional part can be coerced from a string to an integer, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function stringToFloat(string $value): float
    {
        if (Coerceable::stringToFloat($value)) {
            return \floatval($value);
        }

        throw new TypeError('Only numbers with no fractional part can be coerced from a string to a float, given value: ' . Debug::sanitizeData($value));
    }
}

<?php

namespace Squirrel\Types;

use Stringable;

final class Coerceable
{
    /**
     * @pure
     */
    public static function toBool(mixed $value, bool $allowEmptyString = false, bool $allowFloat = false): bool
    {
        if (\is_bool($value)) {
            return true;
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

        return false;
    }

    /**
     * @pure
     */
    public static function toInt(mixed $value, bool $allowBool = false): bool
    {
        if (\is_int($value)) {
            return true;
        }

        if (\is_bool($value) && $allowBool === true) {
            return true;
        }

        if (\is_float($value)) {
            return self::floatToInt($value);
        }

        if (\is_string($value)) {
            return self::stringToInt($value);
        }

        return false;
    }

    /**
     * @pure
     */
    public static function toFloat(mixed $value, bool $allowBool = false): bool
    {
        if (\is_int($value) || \is_float($value)) {
            return true;
        }

        if (\is_bool($value) && $allowBool === true) {
            return true;
        }

        if (\is_string($value)) {
            return self::stringToFloat($value);
        }

        return false;
    }

    /**
     * @pure
     */
    public static function toString(mixed $value, bool $allowBool = false, bool $allowStringable = false): bool
    {
        if (\is_string($value)) {
            return true;
        }

        if (\is_int($value) || \is_float($value)) {
            return true;
        }

        if (\is_bool($value) && $allowBool === true) {
            return true;
        }

        if ($value instanceof Stringable && $allowStringable === true) {
            return true;
        }

        return false;
    }

    /**
     * @pure
     */
    public static function stringToBool(string $value, bool $allowEmptyString = false): bool
    {
        if (
            $value === '0'
            || $value === '1'
            || (
                $allowEmptyString === true
                && $value === ''
            )
        ) {
            return true;
        }

        return false;
    }

    /**
     * @pure
     */
    public static function intToBool(int $value): bool
    {
        return match ($value) {
            0, 1 => true,
            default => false,
        };
    }

    /**
     * @pure
     */
    public static function floatToBool(float $value): bool
    {
        if (
            \abs(1.0 - $value) < PHP_FLOAT_EPSILON
            || \abs(0.0 - $value) < PHP_FLOAT_EPSILON
        ) {
            return true;
        }

        return false;
    }

    /**
     * @pure
     */
    public static function floatToInt(float $value): bool
    {
        if (
            \abs($value - \intval($value)) < PHP_FLOAT_EPSILON
        ) {
            return true;
        }

        return false;
    }

    /**
     * @pure
     */
    public static function stringToInt(string $value): bool
    {
        if (
            \is_numeric($value)
            && \abs(\floatval($value) - \intval($value)) < PHP_FLOAT_EPSILON
        ) {
            return true;
        }

        return false;
    }

    /**
     * @pure
     */
    public static function stringToFloat(string $value): bool
    {
        if (
            \is_numeric($value)
        ) {
            return true;
        }

        return false;
    }
}

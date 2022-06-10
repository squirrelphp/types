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

        if (
            $value === 0
            || $value === 1
        ) {
            return true;
        }

        if (
            $allowFloat === true
            && \is_float($value)
            && (
                \abs(1.0 - $value) < PHP_FLOAT_EPSILON
                || \abs(0.0 - $value) < PHP_FLOAT_EPSILON
            )
        ) {
            return true;
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

        if (
            $allowBool === true
            && \is_bool($value)
        ) {
            return true;
        }

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
    public static function toFloat(mixed $value, bool $allowBool = false): bool
    {
        if (
            \is_int($value)
            || \is_float($value)
        ) {
            return true;
        }

        if (
            $allowBool === true
            && \is_bool($value)
        ) {
            return true;
        }

        if (
            \is_string($value)
            && \is_numeric($value)
        ) {
            return true;
        }

        return false;
    }

    /**
     * @pure
     */
    public static function toString(mixed $value, bool $allowBool = false, bool $allowStringable = false): bool
    {
        if (
            \is_string($value)
        ) {
            return true;
        }

        if (
            \is_int($value)
            || \is_float($value)
        ) {
            return true;
        }

        if (
            $allowBool === true
            && \is_bool($value)
        ) {
            return true;
        }

        if (
            $allowStringable === true
            && $value instanceof Stringable
        ) {
            return true;
        }

        return false;
    }
}

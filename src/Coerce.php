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

        if (
            $value === '0'
            || $value === '1'
            || (
                $allowEmptyString === true
                && $value === ''
            )
        ) {
            return $value === '1';
        }

        if (
            $value === 0
            || $value === 1
        ) {
            return $value === 1;
        }

        if (
            $allowFloat === true
            && \is_float($value)
            && (
                \abs(1.0 - $value) < PHP_FLOAT_EPSILON
                || \abs(0.0 - $value) < PHP_FLOAT_EPSILON
            )
        ) {
            return \abs(1.0 - $value) < PHP_FLOAT_EPSILON;
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

        if (
            $allowBool === true
            && \is_bool($value)
        ) {
            return $value === true ? 1 : 0;
        }

        if (
            \is_numeric($value)
            && \abs(\floatval($value) - \intval($value)) < PHP_FLOAT_EPSILON
        ) {
            return \intval($value);
        }

        throw new TypeError('Only ' . ( $allowBool ? 'booleans, ' : '' ) . 'numeric strings and floats with no fractional part are alternative coerceable values for an int, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function toFloat(mixed $value, bool $allowBool = false): float
    {
        if (
            \is_int($value)
            || \is_float($value)
        ) {
            return $value;
        }

        if (
            $allowBool === true
            && \is_bool($value)
        ) {
            return $value === true ? 1 : 0;
        }

        if (
            \is_string($value)
            && \is_numeric($value)
        ) {
            return \floatval($value);
        }

        throw new TypeError('Only ' . ( $allowBool ? 'booleans and ' : '' ) . 'numeric strings are alternative coerceable values for a float, given value: ' . Debug::sanitizeData($value));
    }

    /**
     * @pure
     * @throws TypeError
     */
    public static function toString(mixed $value, bool $allowBool = false, bool $allowStringable = false): string
    {
        if (
            \is_string($value)
        ) {
            return $value;
        }

        if (
            \is_int($value)
            || \is_float($value)
        ) {
            return \strval($value);
        }

        if (
            $allowBool === true
            && \is_bool($value)
        ) {
            return $value === true ? '1' : '0';
        }

        if (
            $allowStringable === true
            && $value instanceof Stringable
        ) {
            return $value->__toString();
        }

        throw new TypeError('Only ' . ( $allowBool ? 'booleans, ' : '' ) . '' . ( $allowStringable ? 'Stringable, ' : '' ) . 'integers and floats are alternative coerceable values for a string, given value: ' . Debug::sanitizeData($value));
    }
}

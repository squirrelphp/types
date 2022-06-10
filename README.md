Squirrel Types
=====================

[![Software License](https://img.shields.io/badge/coverage-100%25-brightgreen)](LICENSE) [![Packagist Version](https://img.shields.io/packagist/v/squirrelphp/types.svg?style=flat-round)](https://packagist.org/packages/squirrelphp/types) [![PHP Version](https://img.shields.io/packagist/php-v/squirrelphp/types.svg)](https://packagist.org/packages/squirrelphp/types) [![Software License](https://img.shields.io/badge/license-MIT-success.svg?style=flat-round)](LICENSE)

Explicit handling of type coercions and enforcement in PHP in order to deal with unknown data in a more predictable and safe way.

Installation
------------

    composer require squirrelphp/types

Table of contents
-----------------

- [Introduction](#introduction)
- [Coercion behavior overview](#coercion-behavior-overview)
- [Test if value can be coerced](#test-if-value-can-be-coerced)
- [Coerce a value](#coerce-a-value)
- [Enforce a type for a value](#enforce-a-type-for-a-value)

Introduction
------------

When getting values from a database or an API (or even just another PHP component you do not know) you have an expectation of what type of value you will get, but you might get something more or less different.

A database might give you the string "1" for a boolean, or the integer 1, and that would often be fine (many databases have no boolean type, so some coercion is often necessary). But getting the string "hello" or the integer -30 should not be fine for a boolean and most likely points to a mistake - maybe the expected type is wrong, or the wrong field in the database was retrieved.

This small component coerces and enforces types and is fully tested to behave in a predictable way. This should often be better than using other coercion methods like explicit casts `(bool)` / `boolval()`, as these will coerce any value, while this component will reject unreasonable values and throw a TypeError. It coerces less values than PHP does in coercive typing mode, as PHP accepts quite a few questionable values for legacy/BC reasons.

Coercion behavior overview
--------------------------

All argument flags mentioned below are set to false by default for a more conservative coercion behavior. Enable them only if it is necessary for your use case.

### toBool

- Always accepts bools
- Accepts "0" and "1" strings
- Accepts 0 and 1 ints
- Only allows "" string if the argument `$allowEmptyString` is set to true
- Only allows 0.0 and 1.0 floats if the argument `$allowFloat` is set to true

### toInt

- Always accepts ints
- Accepts floats and numeric strings without a fractional part
- Only allows bools if the argument `$allowBool` is set to true

### toFloat

- Always accepts ints and floats
- Accepts numeric strings
- Only allows bools if the argument `$allowBool` is set to true

### toString

- Always accepts strings
- Accepts any ints and floats
- Only allows bools if the argument `$allowBool` is set to true
- Only allows Stringable objects if the argument `$allowStringable` is set to true

Test if value can be coerced
----------------------------

All these functions have the mixed `$value` as their first argument and return true or false:

### Coerceable::toBool

Returns true if `$value` is one of the following:

- A boolean
- A string with value '0' or '1'
- An int with value 0 or 1
- An empty string - only if the argument `$allowEmptyString` is set to true
- A float with value 0 or 1 - only if the `$allowFloat` argument is set to true

For any other values it returns false.

### Coerceable::toInt

Returns true if `$value` is one of the following:

- An integer
- A float without fractional part
- A numeric string without fractional part
- A boolean - only if the `$allowBool` argument is set to true

For any other values it returns false.

### Coerceable::toFloat

Returns true if `$value` is one of the following:

- An integer or float
- A numeric string
- A boolean - only if the `$allowBool` argument is set to true

For any other values it returns false.

### Coerceable::toString

Returns true if `$value` is one of the following:

- A string
- An integer or float
- A boolean - only if the `$allowBool` argument is set to true
- A Stringable object - only if the `$allowStringable` argument is set to true

For any other values it returns false.

Coerce a value
--------------

All these functions have the mixed `$value` as their first argument and return the type they are coercing (or throw a TypeError).

### Coerce::toBool

Returns a boolean if the given value is coerceable, see [Coerceable::toBool for valid values](#coerceabletobool), or a TypeError if the value is not coerceable.

### Coerce::toInt

Returns an integer if the given value is coerceable, see [Coerceable::toInt for valid values](#coerceabletoint), or a TypeError if the value is not coerceable.

### Coerce::toFloat

Returns a float if the given value is coerceable, see [Coerceable::toFloat for valid values](#coerceabletofloat), or a TypeError if the value is not coerceable.

### Coerce::toString

Returns a string if the given value is coerceable, see [Coerceable::toString for valid values](#coerceabletoint), or a TypeError if the value is not coerceable.

Enforce a type for a value
--------------------------

All these functions have the mixed `$value` as their only argument and return the type they are enforcing, according to the same logic as strict mode in PHP.

### Enforce::asBool

Returns `$value` as a boolean if it is a boolean. Throws a TypeError otherwise.

### Enforce::asInt

Returns `$value` as an integer if it is an integer. Throws a TypeError otherwise.

### Enforce::asFloat

Returns `$value` as a float if it is an integer or a float. Throws a TypeError otherwise.

### Enforce::asString

Returns `$value` as a string if it is a string. Throws a TypeError otherwise.
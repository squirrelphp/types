<?php

namespace Squirrel\Types\Tests;

use Squirrel\Debug\Debug;
use Squirrel\Types\Coerce;
use Squirrel\Types\Coerceable;
use TypeError;

class CoerceTest extends \PHPUnit\Framework\TestCase
{
    public function testCoerceToInt(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => 0,
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => 0,
                'coerceable' => true,
            ],
            [
                'input' => 31,
                'output' => 31,
                'coerceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Only numbers with no fractional part can be coerced from a string to an integer, given value: \'failed\''),
                'coerceable' => false,
            ],
            [
                'input' => '39hello',
                'output' => new TypeError('Only numbers with no fractional part can be coerced from a string to an integer, given value: \'39hello\''),
                'coerceable' => false,
            ],
            [
                'input' => '33.0',
                'output' => 33,
                'coerceable' => true,
            ],
            [
                'input' => true,
                'output' => new TypeError('Only numeric strings and floats with no fractional part are alternative coerceable values for an integer, given value: true'),
                'coerceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Only numeric strings and floats with no fractional part are alternative coerceable values for an integer, given value: false'),
                'coerceable' => false,
            ],
            [
                'input' => true,
                'output' => 1,
                'coerceable' => true,
                'parameters' => [
                    'allowBool' => true,
                ],
            ],
            [
                'input' => false,
                'output' => 0,
                'coerceable' => true,
                'parameters' => [
                    'allowBool' => true,
                ],
            ],
            [
                'input' => 1.5,
                'output' => new TypeError('Only numbers with no fractional part can be coerced from a float to an integer, given value: 1.5'),
                'coerceable' => false,
            ],
            [
                'input' => '',
                'output' => new TypeError('Only numbers with no fractional part can be coerced from a string to an integer, given value: \'\''),
                'coerceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Only numeric strings and floats with no fractional part are alternative coerceable values for an integer, given value: object(class@anonymous' . '$end$'),
                'coerceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Only numeric strings and floats with no fractional part are alternative coerceable values for an integer, given value: []'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Only numeric strings and floats with no fractional part are alternative coerceable values for an integer, given value: object(stdClass)'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Only numeric strings and floats with no fractional part are alternative coerceable values for an integer, given value: NULL'),
                'coerceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Coerceable::toInt(...), Coerce::toInt(...));
        }
    }

    public function testCoerceToFloat(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => 0.0,
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => 0.0,
                'coerceable' => true,
            ],
            [
                'input' => 39.5,
                'output' => 39.5,
                'coerceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Only numbers with no fractional part can be coerced from a string to a float, given value: \'failed\''),
                'coerceable' => false,
            ],
            [
                'input' => '39hello',
                'output' => new TypeError('Only numbers with no fractional part can be coerced from a string to a float, given value: \'39hello\''),
                'coerceable' => false,
            ],
            [
                'input' => '33.0',
                'output' => 33.0,
                'coerceable' => true,
            ],
            [
                'input' => true,
                'output' => new TypeError('Only numeric strings are alternative coerceable values for a float, given value: true'),
                'coerceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Only numeric strings are alternative coerceable values for a float, given value: false'),
                'coerceable' => false,
            ],
            [
                'input' => true,
                'output' => 1.0,
                'coerceable' => true,
                'parameters' => [
                    'allowBool' => true,
                ],
            ],
            [
                'input' => false,
                'output' => 0.0,
                'coerceable' => true,
                'parameters' => [
                    'allowBool' => true,
                ],
            ],
            [
                'input' => 13,
                'output' => 13.0,
                'coerceable' => true,
            ],
            [
                'input' => -55,
                'output' => -55.0,
                'coerceable' => true,
            ],
            [
                'input' => '',
                'output' => new TypeError('Only numbers with no fractional part can be coerced from a string to a float, given value: \'\''),
                'coerceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Only numeric strings are alternative coerceable values for a float, given value: object(class@anonymous' . '$end$'),
                'coerceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Only numeric strings are alternative coerceable values for a float, given value: []'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Only numeric strings are alternative coerceable values for a float, given value: object(stdClass)'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Only numeric strings are alternative coerceable values for a float, given value: NULL'),
                'coerceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Coerceable::toFloat(...), Coerce::toFloat(...));
        }
    }

    public function testCoerceToString(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => '0',
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => '0',
                'coerceable' => true,
            ],
            [
                'input' => 39.5,
                'output' => '39.5',
                'coerceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => 'failed',
                'coerceable' => true,
            ],
            [
                'input' => '39hello',
                'output' => '39hello',
                'coerceable' => true,
            ],
            [
                'input' => '33.0',
                'output' => '33.0',
                'coerceable' => true,
            ],
            [
                'input' => true,
                'output' => new TypeError('Only integers and floats are alternative coerceable values for a string, given value: true'),
                'coerceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Only integers and floats are alternative coerceable values for a string, given value: false'),
                'coerceable' => false,
            ],
            [
                'input' => true,
                'output' => '1',
                'coerceable' => true,
                'parameters' => [
                    'allowBool' => true,
                ],
            ],
            [
                'input' => false,
                'output' => '0',
                'coerceable' => true,
                'parameters' => [
                    'allowBool' => true,
                ],
            ],
            [
                'input' => 13,
                'output' => '13',
                'coerceable' => true,
            ],
            [
                'input' => -55,
                'output' => '-55',
                'coerceable' => true,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Only integers and floats are alternative coerceable values for a string, given value: object(class@anonymous' . '$end$'),
                'coerceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => 'amazing',
                'coerceable' => true,
                'parameters' => [
                    'allowStringable' => true,
                ],
            ],
            [
                'input' => [],
                'output' => new TypeError('Only integers and floats are alternative coerceable values for a string, given value: []'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Only integers and floats are alternative coerceable values for a string, given value: object(stdClass)'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Only integers and floats are alternative coerceable values for a string, given value: NULL'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Only booleans, Stringable, integers and floats are alternative coerceable values for a string, given value: NULL'),
                'coerceable' => false,
                'parameters' => [
                    'allowBool' => true,
                    'allowStringable' => true,
                ],
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Coerceable::toString(...), Coerce::toString(...));
        }
    }

    public function testCoerceToBool(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => new TypeError('Only 0 and 1 are alternative coerceable values for a boolean, given value: 0.0'),
                'coerceable' => false,
            ],
            [
                'input' => 0.0,
                'output' => false,
                'coerceable' => true,
                'parameters' => [
                    'allowFloat' => true,
                ],
            ],
            [
                'input' => 1.0,
                'output' => true,
                'coerceable' => true,
                'parameters' => [
                    'allowFloat' => true,
                ],
            ],
            [
                'input' => 1.5,
                'output' => new TypeError('Only 0 and 1 can be coerced from a float to a boolean, given value: 1.5'),
                'coerceable' => false,
                'parameters' => [
                    'allowFloat' => true,
                ],
            ],
            [
                'input' => true,
                'output' => true,
                'coerceable' => true,
            ],
            [
                'input' => false,
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => 0,
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => 1,
                'output' => true,
                'coerceable' => true,
            ],
            [
                'input' => '1',
                'output' => true,
                'coerceable' => true,
            ],
            [
                'input' => '',
                'output' => new TypeError('Only 0 and 1 are alternative coerceable values for a boolean, given value: \'\''),
                'coerceable' => false,
            ],
            [
                'input' => '',
                'output' => false,
                'coerceable' => true,
                'parameters' => [
                    'allowEmptyString' => true,
                ],
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Only 0 and 1 are alternative coerceable values for a boolean, given value: object(class@anonymous' . '$end$'),
                'coerceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Only 0 and 1 are alternative coerceable values for a boolean, given value: []'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Only 0 and 1 are alternative coerceable values for a boolean, given value: object(stdClass)'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Only 0 and 1 are alternative coerceable values for a boolean, given value: NULL'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Only 0 and 1 and \'\' are alternative coerceable values for a boolean, given value: NULL'),
                'coerceable' => false,
                'parameters' => [
                    'allowFloat' => true,
                    'allowEmptyString' => true,
                ],
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Coerceable::toBool(...), Coerce::toBool(...));
        }
    }

    public function testCoerceBoolToString(): void
    {
        $this->assertSame('0', Coerce::boolToString(false));
        $this->assertSame('1', Coerce::boolToString(true));
    }

    public function testCoerceIntToString(): void
    {
        $this->assertSame('-33', Coerce::intToString(-33));
        $this->assertSame('176', Coerce::intToString(176));
    }

    public function testCoerceFloatToString(): void
    {
        $this->assertSame('-33.3', Coerce::floatToString(-33.3));
        $this->assertSame('176.8', Coerce::floatToString(176.8));
    }

    private function doOneTest(array $entry, callable $coerceable, callable $coerce): void
    {
        $coerceParameter = $entry['parameters'] ?? [];
        $isCoerceable = $entry['coerceable'];
        $input = $entry['input'];
        $expectedOutput = $entry['output'];

        $this->assertSame($isCoerceable, $coerceable($input, ...$coerceParameter), 'Coerceable is unexpectedly ' . ( $isCoerceable ? 'false' : 'true' ) . ' for ' . Debug::sanitizeData($input) . ' in entry ' . Debug::sanitizeData($entry));

        try {
            $coerceOutput = $coerce($input, ...$coerceParameter);

            if ($isCoerceable === false) {
                $this->fail('Coercion did not throw TypeError for ' . Debug::sanitizeData($input) . ' in entry ' . Debug::sanitizeData($entry));
            }
        } catch (TypeError $e) {
            if ($isCoerceable === true) {
                $this->fail('Unexpected TypeError for ' . Debug::sanitizeData($input) . ' with message ' . $e->getMessage() . ' in entry ' . Debug::sanitizeData($entry));
            }

            $this->assertInstanceOf(TypeError::class, $expectedOutput);
            if (\str_ends_with($expectedOutput->getMessage(), '$end$')) {
                $this->assertStringStartsWith(\substr($expectedOutput->getMessage(), 0, -5), $e->getMessage());
            } else {
                $this->assertSame($expectedOutput->getMessage(), $e->getMessage());
            }
        }

        if ($isCoerceable === true) {
            $this->assertSame($expectedOutput, $coerceOutput ?? null, 'Coerce has output ' . Debug::sanitizeData($coerceOutput) . ' for ' . Debug::sanitizeData($input) . ' in entry ' . Debug::sanitizeData($entry));
        }
    }
}

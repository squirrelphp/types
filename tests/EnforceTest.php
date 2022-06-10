<?php

namespace Squirrel\Types\Tests;

use Squirrel\Debug\Debug;
use Squirrel\Types\Enforce;
use TypeError;

class EnforceTest extends \PHPUnit\Framework\TestCase
{
    public function testEnforceToInt(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => 0,
                'enforceable' => true,
            ],
            [
                'input' => -33,
                'output' => -33,
                'enforceable' => true,
            ],
            [
                'input' => 7835,
                'output' => 7835,
                'enforceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => new TypeError('Value does not contain int: 0.0'),
                'enforceable' => false,
            ],
            [
                'input' => 39.5,
                'output' => new TypeError('Value does not contain int: 39.5'),
                'enforceable' => false,
            ],
            [
                'input' => -1.75,
                'output' => new TypeError('Value does not contain int: -1.75'),
                'enforceable' => false,
            ],
            [
                'input' => '0',
                'output' => new TypeError('Value does not contain int: \'0\''),
                'enforceable' => false,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Value does not contain int: \'failed\''),
                'enforceable' => false,
            ],
            [
                'input' => '',
                'output' => new TypeError('Value does not contain int: \'\''),
                'enforceable' => false,
            ],
            [
                'input' => true,
                'output' => new TypeError('Value does not contain int: true'),
                'enforceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Value does not contain int: false'),
                'enforceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value does not contain int: object(class@anonymous' . '$end$'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value does not contain int: []'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value does not contain int: object(stdClass)'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value does not contain int: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Enforce::asInt(...));
        }
    }

    public function testEnforceToFloat(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => 0.0,
                'enforceable' => true,
            ],
            [
                'input' => -33,
                'output' => -33.0,
                'enforceable' => true,
            ],
            [
                'input' => 7835,
                'output' => 7835.0,
                'enforceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => 0.0,
                'enforceable' => true,
            ],
            [
                'input' => 39.5,
                'output' => 39.5,
                'enforceable' => true,
            ],
            [
                'input' => -1.75,
                'output' => -1.75,
                'enforceable' => true,
            ],
            [
                'input' => '0',
                'output' => new TypeError('Value does not contain float or int: \'0\''),
                'enforceable' => false,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Value does not contain float or int: \'failed\''),
                'enforceable' => false,
            ],
            [
                'input' => '',
                'output' => new TypeError('Value does not contain float or int: \'\''),
                'enforceable' => false,
            ],
            [
                'input' => true,
                'output' => new TypeError('Value does not contain float or int: true'),
                'enforceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Value does not contain float or int: false'),
                'enforceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value does not contain float or int: object(class@anonymous' . '$end$'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value does not contain float or int: []'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value does not contain float or int: object(stdClass)'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value does not contain float or int: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Enforce::asFloat(...));
        }
    }

    public function testEnforceToBool(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => new TypeError('Value does not contain bool: 0'),
                'enforceable' => false,
            ],
            [
                'input' => -33,
                'output' => new TypeError('Value does not contain bool: -33'),
                'enforceable' => false,
            ],
            [
                'input' => 7835,
                'output' => new TypeError('Value does not contain bool: 7835'),
                'enforceable' => false,
            ],
            [
                'input' => 0.0,
                'output' => new TypeError('Value does not contain bool: 0.0'),
                'enforceable' => false,
            ],
            [
                'input' => 39.5,
                'output' => new TypeError('Value does not contain bool: 39.5'),
                'enforceable' => false,
            ],
            [
                'input' => -1.75,
                'output' => new TypeError('Value does not contain bool: -1.75'),
                'enforceable' => false,
            ],
            [
                'input' => '0',
                'output' => new TypeError('Value does not contain bool: \'0\''),
                'enforceable' => false,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Value does not contain bool: \'failed\''),
                'enforceable' => false,
            ],
            [
                'input' => '',
                'output' => new TypeError('Value does not contain bool: \'\''),
                'enforceable' => false,
            ],
            [
                'input' => true,
                'output' => true,
                'enforceable' => true,
            ],
            [
                'input' => false,
                'output' => false,
                'enforceable' => true,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value does not contain bool: object(class@anonymous' . '$end$'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value does not contain bool: []'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value does not contain bool: object(stdClass)'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value does not contain bool: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Enforce::asBool(...));
        }
    }

    public function testEnforceToString(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => new TypeError('Value does not contain string: 0'),
                'enforceable' => false,
            ],
            [
                'input' => -33,
                'output' => new TypeError('Value does not contain string: -33'),
                'enforceable' => false,
            ],
            [
                'input' => 7835,
                'output' => new TypeError('Value does not contain string: 7835'),
                'enforceable' => false,
            ],
            [
                'input' => 0.0,
                'output' => new TypeError('Value does not contain string: 0.0'),
                'enforceable' => false,
            ],
            [
                'input' => 39.5,
                'output' => new TypeError('Value does not contain string: 39.5'),
                'enforceable' => false,
            ],
            [
                'input' => -1.75,
                'output' => new TypeError('Value does not contain string: -1.75'),
                'enforceable' => false,
            ],
            [
                'input' => '0',
                'output' => '0',
                'enforceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => 'failed',
                'enforceable' => true,
            ],
            [
                'input' => '',
                'output' => '',
                'enforceable' => true,
            ],
            [
                'input' => true,
                'output' => new TypeError('Value does not contain string: true'),
                'enforceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Value does not contain string: false'),
                'enforceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value does not contain string: object(class@anonymous' . '$end$'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value does not contain string: []'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value does not contain string: object(stdClass)'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value does not contain string: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->doOneTest($entry, Enforce::asString(...));
        }
    }

    private function doOneTest(array $entry, callable $enforce): void
    {
        $isEnforceable = $entry['enforceable'];
        $input = $entry['input'];
        $expectedOutput = $entry['output'];

        try {
            $enforceOutput = $enforce($input);

            if ($isEnforceable === false) {
                $this->fail('Enforce did not throw TypeError for ' . Debug::sanitizeData($input) . ' in entry ' . Debug::sanitizeData($entry));
            }
        } catch (TypeError $e) {
            if ($isEnforceable === true) {
                $this->fail('Unexpected TypeError for ' . Debug::sanitizeData($input) . ' with message ' . $e->getMessage() . ' in entry ' . Debug::sanitizeData($entry));
            }

            $this->assertInstanceOf(TypeError::class, $expectedOutput);
            if (\str_ends_with($expectedOutput->getMessage(), '$end$')) {
                $this->assertStringStartsWith(\substr($expectedOutput->getMessage(), 0, -5), $e->getMessage());
            } else {
                $this->assertSame($expectedOutput->getMessage(), $e->getMessage());
            }
        }

        if ($isEnforceable === true) {
            $this->assertSame($expectedOutput, $enforceOutput ?? null, 'Enforce has output ' . Debug::sanitizeData($enforceOutput) . ' for ' . Debug::sanitizeData($input) . ' in entry ' . Debug::sanitizeData($entry));
        }
    }
}

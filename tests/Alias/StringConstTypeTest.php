<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\StringConstType;
use TochkaTest\Types\TestCase;

#[CoversClass(StringConstType::class)]
class StringConstTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new StringConstType('Hello');
        self::assertEquals("'Hello'", (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

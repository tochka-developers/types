<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\NumericStringType;
use TochkaTest\Types\TestCase;

#[CoversClass(NumericStringType::class)]
class NumericStringTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NumericStringType();
        self::assertEquals('numeric-string', (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

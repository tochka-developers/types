<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\NumericType;
use TochkaTest\Types\TestCase;

#[CoversClass(NumericType::class)]
class NumericTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NumericType();
        self::assertEquals('numeric', (string) $type);
        self::assertEquals('int|float|string', $type->toNativeTypeString());
    }
}

<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\FloatConstType;
use TochkaTest\Types\TestCase;

#[CoversClass(FloatConstType::class)]
class FloatConstTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new FloatConstType(12.345);
        self::assertEquals('12.345', (string) $type);
        self::assertEquals('float', $type->toNativeTypeString());
    }
}

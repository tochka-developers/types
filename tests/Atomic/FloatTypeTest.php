<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\FloatType;
use TochkaTest\Types\TestCase;

#[CoversClass(FloatType::class)]
class FloatTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new FloatType();
        self::assertEquals('float', (string) $type);
        self::assertEquals('float', $type->toNativeTypeString());
    }
}

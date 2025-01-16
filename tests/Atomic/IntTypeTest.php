<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\IntType;
use TochkaTest\Types\TestCase;

#[CoversClass(IntType::class)]
class IntTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new IntType();
        self::assertEquals('int', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

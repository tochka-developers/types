<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\NullType;
use TochkaTest\Types\TestCase;

#[CoversClass(NullType::class)]
class NullTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NullType();
        self::assertEquals('null', (string) $type);
        self::assertEquals('null', $type->toNativeTypeString());
    }
}

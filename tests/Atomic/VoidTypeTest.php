<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\VoidType;
use TochkaTest\Types\TestCase;

#[CoversClass(VoidType::class)]
class VoidTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new VoidType();
        self::assertEquals('void', (string) $type);
        self::assertEquals('void', $type->toNativeTypeString());
    }
}

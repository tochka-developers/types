<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\MixedType;
use TochkaTest\Types\TestCase;

#[CoversClass(MixedType::class)]
class MixedTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new MixedType();
        self::assertEquals('mixed', (string) $type);
        self::assertEquals('mixed', $type->toNativeTypeString());
    }
}

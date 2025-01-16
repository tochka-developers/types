<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\IntMaskType;
use TochkaTest\Types\TestCase;

#[CoversClass(IntMaskType::class)]
class IntMaskTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new IntMaskType(1, 2, 5);
        self::assertEquals('int-mask<1, 2, 5>', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

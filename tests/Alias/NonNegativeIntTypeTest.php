<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\NonNegativeIntType;
use TochkaTest\Types\TestCase;

#[CoversClass(NonNegativeIntType::class)]
class NonNegativeIntTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NonNegativeIntType();
        self::assertEquals('non-negative-int', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

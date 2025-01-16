<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\NegativeIntType;
use TochkaTest\Types\TestCase;

#[CoversClass(NegativeIntType::class)]
class NegativeIntTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NegativeIntType();
        self::assertEquals('negative-int', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\IntConstType;
use TochkaTest\Types\TestCase;

#[CoversClass(IntConstType::class)]
class IntConstTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new IntConstType(12);
        self::assertEquals('12', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

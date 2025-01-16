<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\PositiveIntType;
use TochkaTest\Types\TestCase;

#[CoversClass(PositiveIntType::class)]
class PositiveIntTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new PositiveIntType();
        self::assertEquals('positive-int', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

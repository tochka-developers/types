<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\ArrayKeyType;
use TochkaTest\Types\TestCase;

#[CoversClass(ArrayKeyType::class)]
class ArrayKeyTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new ArrayKeyType();
        self::assertEquals('array-key', (string) $type);
        self::assertEquals('int|string', $type->toNativeTypeString());
    }
}

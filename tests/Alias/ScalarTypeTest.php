<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\ScalarType;
use TochkaTest\Types\TestCase;

#[CoversClass(ScalarType::class)]
class ScalarTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new ScalarType();
        self::assertEquals('scalar', (string) $type);
        self::assertEquals('string|int|float|bool', $type->toNativeTypeString());
    }
}

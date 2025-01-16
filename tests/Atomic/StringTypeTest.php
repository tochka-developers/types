<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\StringType;
use TochkaTest\Types\TestCase;

#[CoversClass(StringType::class)]
class StringTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new StringType();
        self::assertEquals('string', (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

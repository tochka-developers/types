<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\NotType;
use Tochka\Types\Atomic\StringType;
use TochkaTest\Types\TestCase;

#[CoversClass(NotType::class)]
class NotTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NotType(new StringType());
        self::assertEquals('!string', (string) $type);
        self::assertEquals('mixed', $type->toNativeTypeString());
    }
}

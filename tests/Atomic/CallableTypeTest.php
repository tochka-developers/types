<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\CallableType;
use TochkaTest\Types\TestCase;

#[CoversClass(CallableType::class)]
class CallableTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new CallableType();
        self::assertEquals('callable', (string) $type);
        self::assertEquals('callable', $type->toNativeTypeString());
    }
}

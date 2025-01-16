<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\CallableStringType;
use TochkaTest\Types\TestCase;

#[CoversClass(CallableStringType::class)]
class CallableStringTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new CallableStringType();
        self::assertEquals('callable-string', (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\NeverType;
use TochkaTest\Types\TestCase;

#[CoversClass(NeverType::class)]
class NeverTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NeverType();
        self::assertEquals('never', (string) $type);
        self::assertEquals('never', $type->toNativeTypeString());
    }
}

<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\TrueType;
use TochkaTest\Types\TestCase;

#[CoversClass(TrueType::class)]
class TrueTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new TrueType();
        self::assertEquals('true', (string) $type);
        self::assertEquals('true', $type->toNativeTypeString());
    }
}

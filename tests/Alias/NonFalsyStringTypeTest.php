<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\NonFalsyStringType;
use TochkaTest\Types\TestCase;

#[CoversClass(NonFalsyStringType::class)]
class NonFalsyStringTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NonFalsyStringType();
        self::assertEquals('non-falsy-string', (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

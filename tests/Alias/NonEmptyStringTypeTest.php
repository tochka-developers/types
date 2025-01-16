<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\NonEmptyStringType;
use TochkaTest\Types\TestCase;

#[CoversClass(NonEmptyStringType::class)]
class NonEmptyStringTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NonEmptyStringType();
        self::assertEquals('non-empty-string', (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

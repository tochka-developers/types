<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\NonPositiveIntType;
use TochkaTest\Types\TestCase;

#[CoversClass(NonPositiveIntType::class)]
class NonPositiveIntTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new NonPositiveIntType();
        self::assertEquals('non-positive-int', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\TruthyStringType;
use TochkaTest\Types\TestCase;

#[CoversClass(TruthyStringType::class)]
class TruthyStringTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new TruthyStringType();
        self::assertEquals('truthy-string', (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

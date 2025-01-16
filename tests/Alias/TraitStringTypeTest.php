<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\TraitStringType;
use TochkaTest\Types\TestCase;

#[CoversClass(TraitStringType::class)]
class TraitStringTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new TraitStringType();
        self::assertEquals('trait-string', (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

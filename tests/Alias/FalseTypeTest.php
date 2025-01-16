<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\FalseType;
use TochkaTest\Types\TestCase;

#[CoversClass(FalseType::class)]
class FalseTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new FalseType();
        self::assertEquals('false', (string) $type);
        self::assertEquals('false', $type->toNativeTypeString());
    }
}

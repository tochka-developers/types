<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Alias\IntMaskOfType;
use TochkaTest\Types\TestCase;

#[CoversClass(IntMaskOfType::class)]
class IntMaskOfTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new IntMaskOfType('Hello');
        self::assertEquals('int-mask-of<Hello>', (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

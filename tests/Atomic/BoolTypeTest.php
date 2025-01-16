<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Atomic\BoolType;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(BoolType::class)]
class BoolTypeTest extends TestCase
{
    public static function stringProvider(): iterable
    {
        yield [new BoolType(), 'bool'];
        yield [new BoolType(true), 'true'];
        yield [new BoolType(false), 'false'];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals($expectedString, $type->toNativeTypeString());
    }
}

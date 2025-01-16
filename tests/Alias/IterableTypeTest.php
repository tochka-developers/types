<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Alias\IterableType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(IterableType::class)]
class IterableTypeTest extends TestCase
{
    public static function stringProvider(): iterable
    {
        yield [new IterableType(), 'iterable'];
        yield [new IterableType(new StringType()), 'iterable<string>'];
        yield [new IterableType(new StringType(), new IntType()), 'iterable<string, int>'];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('iterable', $type->toNativeTypeString());
    }
}

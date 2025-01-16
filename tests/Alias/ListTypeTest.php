<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Alias\ListType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\NeverType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Misc\ShapeItem;
use Tochka\Types\Misc\ShapeItems;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(ListType::class)]
class ListTypeTest extends TestCase
{
    public static function stringProvider(): iterable
    {
        yield [new ListType(), 'list'];
        yield [new ListType(new StringType()), 'list<string>'];
        yield [new ListType(new NeverType()), 'list{}'];
        yield [
            new ListType(
                new NeverType(),
                new ShapeItems(
                    new ShapeItem(new StringType()),
                    new ShapeItem(new IntType()),
                ),
            ),
            'list{string, int}',
        ];
        yield [
            new ListType(
                new MixedType(),
                new ShapeItems(
                    new ShapeItem(new StringType()),
                    new ShapeItem(new IntType(), true),
                ),
            ),
            'list{0: string, 1?: int, ...}',
        ];
        yield [
            new ListType(
                new StringType(),
                new ShapeItems(
                    new ShapeItem(new StringType()),
                    new ShapeItem(new IntType(), true),
                ),
            ),
            'list{0: string, 1?: int, ...<string>}',
        ];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('array', $type->toNativeTypeString());
    }
}

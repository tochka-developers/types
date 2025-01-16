<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Alias\NonEmptyListType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\NeverType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Misc\ShapeItem;
use Tochka\Types\Misc\ShapeItems;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(NonEmptyListType::class)]
class NonEmptyListTypeTest extends TestCase
{
    public static function stringProvider(): iterable
    {
        yield [new NonEmptyListType(), 'non-empty-list'];
        yield [new NonEmptyListType(new StringType()), 'non-empty-list<string>'];
        yield [new NonEmptyListType(new NeverType()), 'non-empty-list{}'];
        yield [
            new NonEmptyListType(
                new NeverType(),
                new ShapeItems(
                    new ShapeItem(new StringType()),
                    new ShapeItem(new IntType()),
                ),
            ),
            'non-empty-list{string, int}',
        ];
        yield [
            new NonEmptyListType(
                new MixedType(),
                new ShapeItems(
                    new ShapeItem(new StringType()),
                    new ShapeItem(new IntType(), true),
                ),
            ),
            'non-empty-list{0: string, 1?: int, ...}',
        ];
        yield [
            new NonEmptyListType(
                new StringType(),
                new ShapeItems(
                    new ShapeItem(new StringType()),
                    new ShapeItem(new IntType(), true),
                ),
            ),
            'non-empty-list{0: string, 1?: int, ...<string>}',
        ];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('array', $type->toNativeTypeString());
    }
}

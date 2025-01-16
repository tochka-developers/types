<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Alias\IntConstType;
use Tochka\Types\Alias\ListType;
use Tochka\Types\Alias\PositiveIntType;
use Tochka\Types\Alias\StringConstType;
use Tochka\Types\Atomic\ArrayType;
use Tochka\Types\Atomic\BoolType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\NeverType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Misc\KeyShapeItem;
use Tochka\Types\Misc\KeyShapeItems;
use Tochka\Types\Misc\ShapeItem;
use Tochka\Types\Misc\ShapeItems;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(ArrayType::class)]
class ArrayTypeTest extends TestCase
{
    public static function typesProvider(): iterable
    {
        yield [new ArrayType(), new ArrayType(), true];
        yield [new ArrayType(), new MixedType(), false];
        yield [new ArrayType(), new BoolType(), false];
        // list types
        yield [new ArrayType(), new ListType(), true];
        yield [new ArrayType(new MixedType(), new StringType()), new ListType(), false];
        yield [new ArrayType(new MixedType(), new IntType()), new ListType(), true];
        yield [new ArrayType(new MixedType(), new PositiveIntType()), new ListType(), false];
        yield [new ArrayType(new MixedType()), new ListType(new StringType()), true];
        yield [new ArrayType(new StringType()), new ListType(new StringType()), true];
        // shapes
        yield [
            new ArrayType(
                new StringType(),
                new StringType(),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('Hello')),
                    new KeyShapeItem('bar', new StringConstType('Hello')),
                ),
            ),
            true,
        ];
        yield [
            new ArrayType(
                new StringType(),
                new IntType(),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('Hello')),
                    new KeyShapeItem('bar', new StringConstType('Hello')),
                ),
            ),
            false,
        ];
        yield [
            new ArrayType(
                new StringType(),
                new IntType(),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new ShapeItems(
                    new ShapeItem(new StringConstType('Hello')),
                    new ShapeItem(new StringConstType('Hello')),
                ),
            ),
            true,
        ];
        yield [
            new ArrayType(
                new StringType(),
                new IntType(),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new ShapeItems(
                    new ShapeItem(new StringConstType('Hello')),
                    new ShapeItem(new IntConstType(123)),
                ),
            ),
            false,
        ];
        yield [
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType()),
                ),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('Hello')),
                    new KeyShapeItem('bar', new StringConstType('Hello')),
                ),
            ),
            true,
        ];
        yield [
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType()),
                ),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('Hello')),
                    new KeyShapeItem('bar', new IntConstType(12)),
                ),
            ),
            false,
        ];
        yield [
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType()),
                ),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('Hello')),
                ),
            ),
            false,
        ];
        yield [
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType(), true),
                ),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('Hello')),
                ),
            ),
            true,
        ];
        yield [
            new ArrayType(
                new StringType(),
                new StringType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType()),
                ),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('FOO')),
                    new KeyShapeItem('bar', new StringConstType('BAR')),
                    new KeyShapeItem('test1', new StringConstType('TEST1')),
                    new KeyShapeItem('test2', new StringConstType('TEST2')),
                ),
            ),
            true,
        ];
        yield [
            new ArrayType(
                new StringType(),
                new StringType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType()),
                ),
            ),
            new ArrayType(
                new NeverType(),
                new NeverType(),
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringConstType('FOO')),
                    new KeyShapeItem('bar', new StringConstType('BAR')),
                    new KeyShapeItem('test1', new IntConstType(1)),
                    new KeyShapeItem('test2', new StringConstType('TEST2')),
                ),
            ),
            false,
        ];
    }

    #[DataProvider('typesProvider')]
    public function testIsContravariantTo(TypeInterface $initialType, TypeInterface $analyzeType, bool $expected): void
    {
        self::assertEquals($expected, $initialType->isContravariantTo($analyzeType));
    }

    public static function stringProvider(): iterable
    {
        yield [new ArrayType(), 'array'];
        yield [new ArrayType(new StringType()), 'array<string>'];
        yield [new ArrayType(new StringType(), new StringType()), 'array<string, string>'];
        yield [new ArrayType(new NeverType(), new NeverType()), 'array{}'];
        yield [
            new ArrayType(
                new NeverType(),
                shapeItems: new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new IntType(), true),
                ),
            ),
            'array{foo: string, bar?: int}',
        ];
        yield [
            new ArrayType(
                new MixedType(),
                shapeItems: new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType()),
                ),
            ),
            'array{foo: string, bar: string, ...}',
        ];
        yield [
            new ArrayType(
                new StringType(),
                shapeItems: new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType()),
                ),
            ),
            'array{foo: string, bar: string, ...<array-key, string>}',
        ];
        yield [
            new ArrayType(
                new StringType(),
                shapeItems: new ShapeItems(
                    new ShapeItem(new StringType()),
                    new ShapeItem(new StringType()),
                ),
            ),
            'array{string, string, ...<array-key, string>}',
        ];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('array', $type->toNativeTypeString());
    }
}

<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Atomic\ObjectType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Misc\KeyShapeItem;
use Tochka\Types\Misc\KeyShapeItems;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(ObjectType::class)]
class ObjectTypeTest extends TestCase
{
    public static function stringProvider(): iterable
    {
        yield [new ObjectType(), 'object'];
        yield [
            new ObjectType(
                new KeyShapeItems(
                    new KeyShapeItem('foo', new StringType()),
                    new KeyShapeItem('bar', new StringType(), true),
                ),
            ),
            'object{foo: string, bar?: string}',
        ];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('object', $type->toNativeTypeString());
    }
}

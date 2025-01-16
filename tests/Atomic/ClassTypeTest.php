<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Alias\IntRangeType;
use Tochka\Types\Atomic\ClassType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Complex\IntersectType;
use Tochka\Types\Misc\TemplateType;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\Stubs\A;
use TochkaTest\Types\Stubs\B;
use TochkaTest\Types\Stubs\ABImpl;
use TochkaTest\Types\Stubs\AImpl;
use TochkaTest\Types\Stubs\AImplExt;
use TochkaTest\Types\Stubs\BImpl;
use TochkaTest\Types\TestCase;

#[CoversClass(ClassType::class)]
class ClassTypeTest extends TestCase
{
    public static function typesProvider(): iterable
    {
        yield [new ClassType(A::class), new IntType(), false];
        yield [new ClassType(A::class), new MixedType(), false];
        yield [new ClassType(A::class), new ClassType(A::class), true];
        yield [new ClassType(A::class), new ClassType(AImpl::class), true];
        yield [new ClassType(A::class), new ClassType(BImpl::class), false];
        yield [new ClassType(AImpl::class), new ClassType(A::class), false];
        // класс, имплементирующий все интерфейсы пересечения - является ковариантным к этому пересечению
        yield [new ClassType(ABImpl::class), new IntersectType(new ClassType(A::class), new ClassType(B::class)), false];
        // проверим с темплейтами
        yield [
            new ClassType(AImpl::class, [new TemplateType(new IntType())]),
            new ClassType(AImpl::class, [new TemplateType(new IntType())]),
            true,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new IntType())]),
            new ClassType(AImplExt::class, [new TemplateType(new IntType())]),
            true,
        ];
        yield [
            new ClassType(AImplExt::class, [new TemplateType(new IntType())]),
            new ClassType(AImpl::class, [new TemplateType(new IntType())]),
            false,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new IntType())]),
            new ClassType(AImpl::class, [new TemplateType(new IntRangeType())]),
            false,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImpl::class))]),
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImpl::class))]),
            true,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImpl::class))]),
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImplExt::class))]),
            false,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImpl::class), isContravariant: true)]),
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImplExt::class))]),
            true,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImpl::class))]),
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImplExt::class), isCovariant: true)]),
            true,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImplExt::class), isContravariant: true)]),
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImpl::class))]),
            false,
        ];
        yield [
            new ClassType(AImpl::class, [new TemplateType(new ClassType(AImpl::class), isContravariant: true)]),
            new ClassType(AImpl::class, [new TemplateType(new ClassType(BImpl::class))]),
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
        yield [new ClassType('Hello'), 'Hello'];
        yield [
            new ClassType(
                'Hello',
                [
                    new TemplateType(new StringType()),
                    new TemplateType(new StringType(), isCovariant: true),
                    new TemplateType(new StringType(), isContravariant: true),
                ],
            ),
            'Hello<string, string, string>',
        ];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('Hello', $type->toNativeTypeString());
    }
}

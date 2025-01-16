<?php

declare(strict_types=1);

namespace TochkaTest\Types\Complex;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Atomic\ClassType;
use Tochka\Types\Atomic\FloatType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Complex\IntersectType;
use Tochka\Types\Complex\UnionType;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\Stubs\A;
use TochkaTest\Types\Stubs\ABImpl;
use TochkaTest\Types\Stubs\AImpl;
use TochkaTest\Types\Stubs\B;
use TochkaTest\Types\Stubs\BImpl;
use TochkaTest\Types\TestCase;

#[CoversClass(UnionType::class)]
class UnionTypeTest extends TestCase
{
    public static function typesProvider(): iterable
    {
        yield [
            new UnionType(new IntType(), new StringType()),
            new IntType(),
            true,
        ];

        yield [
            new UnionType(new IntType(), new StringType()),
            new MixedType(),
            false,
        ];

        yield [
            new UnionType(new IntType(), new StringType()),
            new FloatType(),
            false,
        ];

        yield [
            new UnionType(new ClassType(A::class), new ClassType(B::class)),
            new ClassType(AImpl::class),
            true,
        ];

        yield [
            new UnionType(new ClassType(A::class), new ClassType(B::class)),
            new ClassType(ABImpl::class),
            true,
        ];

        yield [
            new UnionType(new ClassType(A::class), new ClassType(B::class)),
            new UnionType(new ClassType(AImpl::class), new ClassType(BImpl::class), new ClassType(
                ABImpl::class,
            )),
            true,
        ];

        yield [
            new UnionType(new ClassType(A::class), new ClassType(B::class)),
            new UnionType(new ClassType(ABImpl::class), new IntType()),
            false,
        ];

        yield [
            new UnionType(new ClassType(AImpl::class), new ClassType(BImpl::class)),
            new ClassType(A::class),
            false,
        ];

        yield [
            new UnionType(new ClassType(AImpl::class), new ClassType(BImpl::class)),
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            false,
        ];
    }

    #[DataProvider('typesProvider')]
    public function testIsContravariantTo(TypeInterface $initialType, TypeInterface $analyzeType, bool $expected): void
    {
        self::assertEquals($expected, $initialType->isContravariantTo($analyzeType));
    }
}

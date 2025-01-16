<?php

declare(strict_types=1);

namespace TochkaTest\Types\Complex;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Atomic\ClassType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Complex\IntersectType;
use Tochka\Types\Complex\UnionType;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\Stubs\A;
use TochkaTest\Types\Stubs\ABImpl;
use TochkaTest\Types\Stubs\AImpl;
use TochkaTest\Types\Stubs\B;
use TochkaTest\Types\Stubs\C;
use TochkaTest\Types\Stubs\OtherABImpl;
use TochkaTest\Types\TestCase;

#[CoversClass(IntersectType::class)]
class IntersectTypeTest extends TestCase
{
    public static function typesProvider(): iterable
    {
        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new IntType(),
            false,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new MixedType(),
            false,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new ClassType(AImpl::class),
            false,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new ClassType(ABImpl::class),
            true,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new UnionType(new ClassType(ABImpl::class), new ClassType(AImpl::class)),
            false,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new UnionType(new ClassType(ABImpl::class), new ClassType(OtherABImpl::class)),
            true,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            true,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new IntersectType(new ClassType(A::class), new ClassType(B::class), new ClassType(C::class)),
            true,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new IntersectType(new ClassType(ABImpl::class), new ClassType(C::class)),
            true,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new IntersectType(new ClassType(AImpl::class), new ClassType(B::class)),
            true,
        ];

        yield [
            new IntersectType(new ClassType(A::class), new ClassType(B::class)),
            new IntersectType(new ClassType(AImpl::class), new ClassType(C::class)),
            false,
        ];
    }

    #[DataProvider('typesProvider')]
    public function testIsContravariantTo(TypeInterface $initialType, TypeInterface $analyzeType, bool $expected): void
    {
        self::assertEquals($expected, $initialType->isContravariantTo($analyzeType));
    }
}

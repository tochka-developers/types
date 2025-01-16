<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Alias\IntRangeType;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(IntRangeType::class)]
class IntRangeTypeTest extends TestCase
{
    public static function stringProvider(): iterable
    {
        yield [new IntRangeType(), 'int'];
        yield [new IntRangeType(rangeMin: 123), 'int<123, max>'];
        yield [new IntRangeType(rangeMax: 123), 'int<min, 123>'];
        yield [new IntRangeType(-100, 100), 'int<-100, 100>'];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('int', $type->toNativeTypeString());
    }
}

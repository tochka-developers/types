<?php

declare(strict_types=1);

namespace TochkaTest\Types\Alias;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tochka\Types\Alias\ClassStringType;
use Tochka\Types\TypeInterface;
use TochkaTest\Types\TestCase;

#[CoversClass(ClassStringType::class)]
class ClassStringTypeTest extends TestCase
{
    public static function stringProvider(): iterable
    {
        yield [new ClassStringType(), 'class-string'];
        yield [new ClassStringType('Hello'), 'class-string<Hello>'];
    }

    #[DataProvider('stringProvider')]
    public function testToString(TypeInterface $type, string $expectedString): void
    {
        self::assertEquals($expectedString, (string) $type);
        self::assertEquals('string', $type->toNativeTypeString());
    }
}

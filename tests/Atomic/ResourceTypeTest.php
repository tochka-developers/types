<?php

declare(strict_types=1);

namespace TochkaTest\Types\Atomic;

use PHPUnit\Framework\Attributes\CoversClass;
use Tochka\Types\Atomic\ResourceType;
use TochkaTest\Types\TestCase;

#[CoversClass(ResourceType::class)]
class ResourceTypeTest extends TestCase
{
    public function testToString(): void
    {
        $type = new ResourceType();
        self::assertEquals('resource', (string) $type);
        self::assertEquals('resource', $type->toNativeTypeString());
    }
}

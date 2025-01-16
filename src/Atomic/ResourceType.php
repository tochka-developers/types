<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @implements NamedTypeInterface<resource>
 * @psalm-immutable
 */
readonly class ResourceType implements NamedTypeInterface
{
    /** @use DefaultNullable<resource> */
    use DefaultNullable;

    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof ResourceType;
    }

    public function __toString(): string
    {
        return $this->toNativeTypeString();
    }

    public function toNativeTypeString(): string
    {
        return 'resource';
    }
}

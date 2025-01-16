<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of int
 * @implements NamedTypeInterface<TType>
 * @psalm-immutable
 */
readonly class IntType implements NamedTypeInterface
{
    /** @use DefaultNullable<TType> */
    use DefaultNullable;

    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof IntType;
    }

    public function __toString(): string
    {
        return $this->toNativeTypeString();
    }

    public function toNativeTypeString(): string
    {
        return 'int';
    }
}

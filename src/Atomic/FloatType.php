<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of float
 * @implements NamedTypeInterface<TType>
 * @psalm-immutable
 */
readonly class FloatType implements NamedTypeInterface
{
    /** @use DefaultNullable<TType> */
    use DefaultNullable;

    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof FloatType;
    }

    public function __toString(): string
    {
        return $this->toNativeTypeString();
    }

    public function toNativeTypeString(): string
    {
        return 'float';
    }
}

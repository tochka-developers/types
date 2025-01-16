<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of string
 * @implements NamedTypeInterface<TType>
 * @psalm-immutable
 */
readonly class StringType implements NamedTypeInterface
{
    /** @use DefaultNullable<TType> */
    use DefaultNullable;

    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof StringType;
    }

    public function __toString(): string
    {
        return $this->toNativeTypeString();
    }

    public function toNativeTypeString(): string
    {
        return 'string';
    }
}

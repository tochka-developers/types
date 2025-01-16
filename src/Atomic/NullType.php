<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @implements NamedTypeInterface<null>
 * @psalm-immutable
 */
readonly class NullType implements NamedTypeInterface
{
    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof NullType;
    }

    public function __toString(): string
    {
        return $this->toNativeTypeString();
    }

    public function toNativeTypeString(): string
    {
        return 'null';
    }

    public function isNullable(): bool
    {
        return true;
    }

    public function setNullable(): TypeInterface
    {
        return $this;
    }
}

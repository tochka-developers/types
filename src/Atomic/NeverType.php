<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @implements NamedTypeInterface<never>
 * @psalm-immutable
 */
readonly class NeverType implements NamedTypeInterface
{
    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof NeverType;
    }

    public function __toString(): string
    {
        return $this->toNativeTypeString();
    }

    public function toNativeTypeString(): string
    {
        return 'never';
    }

    public function isNullable(): bool
    {
        return false;
    }

    public function setNullable(): TypeInterface
    {
        return $this;
    }
}

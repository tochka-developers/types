<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @implements NamedTypeInterface<void>
 * @psalm-immutable
 */
readonly class VoidType implements NamedTypeInterface
{
    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof VoidType;
    }

    public function __toString(): string
    {
        return $this->toNativeTypeString();
    }

    public function toNativeTypeString(): string
    {
        return 'void';
    }

    public function isNullable(): bool
    {
        return false;
    }

    /**
     * @psalm-suppress InvalidReturnType,InvalidReturnStatement
     */
    public function setNullable(): TypeInterface
    {
        return $this;
    }
}

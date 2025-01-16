<?php

declare(strict_types=1);

namespace Tochka\Types;

/**
 * @api
 * @template-covariant TType
 * @psalm-immutable
 */
interface TypeInterface extends \Stringable
{
    public function isNullable(): bool;

    public function isContravariantTo(TypeInterface $type): bool;

    /**
     * @return TypeInterface<TType|null>
     */
    public function setNullable(): TypeInterface;

    public function toNativeTypeString(): string;
}

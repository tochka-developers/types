<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template TType
 * @implements NamedTypeInterface<mixed>
 * @psalm-immutable
 */
readonly class NotType implements NamedTypeInterface
{
    /** @use DefaultNullable<mixed> */
    use DefaultNullable;

    /**
     * @param TypeInterface<TType> $type
     * @codeCoverageIgnore
     */
    public function __construct(
        public TypeInterface $type,
    ) {}

    public function isContravariantTo(TypeInterface $type): bool
    {
        return !$this->type->isContravariantTo($type);
    }

    public function __toString(): string
    {
        return '!' . $this->type;
    }

    public function toNativeTypeString(): string
    {
        return 'mixed';
    }
}

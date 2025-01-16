<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\IntType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TValueType of int
 * @extends IntType<TValueType>
 * @psalm-immutable
 */
readonly class IntConstType extends IntType
{
    /**
     * @psalm-param TValueType $value
     * @codeCoverageIgnore
     */
    public function __construct(
        public int $value,
    ) {}

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        if ($type instanceof IntRangeType) {
            return $type->rangeMin === $this->value && $type->rangeMax === $this->value;
        }

        if ($type instanceof IntConstType) {
            return $type->value === $this->value;
        }

        return false;
    }
}

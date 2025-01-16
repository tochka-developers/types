<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\FloatType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TValueType of float
 * @extends FloatType<TValueType>
 * @psalm-immutable
 */
readonly class FloatConstType extends FloatType
{
    /**
     * @psalm-param TValueType $value
     * @codeCoverageIgnore
     */
    public function __construct(
        public float $value,
    ) {}

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        if ($type instanceof FloatConstType) {
            return $type->value === $this->value;
        }

        return false;
    }
}

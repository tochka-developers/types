<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\StringType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TValueType of string
 * @template-extends StringType<TValueType>
 * @psalm-immutable
 */
readonly class StringConstType extends StringType
{
    /**
     * @psalm-param TValueType $value
     * @codeCoverageIgnore
     */
    public function __construct(
        public string $value,
    ) {}

    public function __toString(): string
    {
        return "'" . $this->value . "'";
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof StringConstType && $type->value === $this->value;
    }
}

<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\IntType;
use Tochka\Types\Complex\UnionType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of int
 * @extends IntType<TType>
 * @psalm-immutable
 */
readonly class IntRangeType extends IntType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        public ?int $rangeMin = null,
        public ?int $rangeMax = null,
    ) {}

    public function __toString(): string
    {
        if ($this->rangeMin !== null) {
            if ($this->rangeMax !== null) {
                return 'int<' . $this->rangeMin . ', ' . $this->rangeMax . '>';
            } else {
                return 'int<' . $this->rangeMin . ', max>';
            }
        } elseif ($this->rangeMax !== null) {
            return 'int<min, ' . $this->rangeMax . '>';
        }

        return 'int';
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        if ($type instanceof IntRangeType) {
            return ($this->rangeMin === null || $this->rangeMin <= $type->rangeMin)
                && ($this->rangeMax === null || $this->rangeMax >= $type->rangeMax);
        }

        if ($type instanceof IntConstType) {
            return ($this->rangeMin === null || $this->rangeMin <= $type->value)
                && ($this->rangeMax === null || $this->rangeMax >= $type->value);
        }

        if ($type instanceof UnionType) {
            foreach ($type->types as $subType) {
                if (!$this->isContravariantTo($subType)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }
}

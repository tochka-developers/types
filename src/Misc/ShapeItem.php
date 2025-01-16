<?php

declare(strict_types=1);

namespace Tochka\Types\Misc;

use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType
 * @psalm-immutable
 */
readonly class ShapeItem
{
    /**
     * @psalm-param TypeInterface<TType> $valueType
     */
    public function __construct(
        public TypeInterface $valueType,
        public bool $isOptional = false,
    ) {}
}

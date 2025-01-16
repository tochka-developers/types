<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\StringType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-extends StringType<trait-string>
 * @psalm-immutable
 */
readonly class TraitStringType extends StringType
{
    public function __toString(): string
    {
        return 'trait-string';
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof TraitStringType;
    }
}

<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\StringType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-extends StringType<callable-string>
 * @psalm-immutable
 */
readonly class CallableStringType extends StringType
{
    public function __toString(): string
    {
        return 'callable-string';
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        return $type instanceof CallableStringType;
    }
}

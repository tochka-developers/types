<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\StringType;

/**
 * @api
 * @template-extends StringType<numeric-string>
 * @psalm-immutable
 */
readonly class NumericStringType extends StringType
{
    public function __toString(): string
    {
        return 'numeric-string';
    }
}

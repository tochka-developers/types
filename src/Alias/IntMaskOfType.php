<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\IntType;

/**
 * @api
 * @extends IntType<int>
 * @psalm-immutable
 */
readonly class IntMaskOfType extends IntType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        public string $expression,
    ) {}

    public function __toString(): string
    {
        return 'int-mask-of<' . $this->expression . '>';
    }
}

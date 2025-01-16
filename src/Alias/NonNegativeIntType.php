<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

/**
 * @api
 * @extends IntRangeType<non-negative-int>
 * @psalm-immutable
 */
readonly class NonNegativeIntType extends IntRangeType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct(rangeMin: 0);
    }

    public function __toString(): string
    {
        return 'non-negative-int';
    }
}

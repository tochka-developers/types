<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

/**
 * @api
 * @extends IntRangeType<positive-int>
 * @psalm-immutable
 */
readonly class PositiveIntType extends IntRangeType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct(rangeMin: 1);
    }

    public function __toString(): string
    {
        return 'positive-int';
    }
}

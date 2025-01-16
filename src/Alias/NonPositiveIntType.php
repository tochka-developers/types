<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

/**
 * @api
 * @extends IntRangeType<non-positive-int>
 * @psalm-immutable
 */
readonly class NonPositiveIntType extends IntRangeType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct(rangeMax: 0);
    }

    public function __toString(): string
    {
        return 'non-positive-int';
    }
}

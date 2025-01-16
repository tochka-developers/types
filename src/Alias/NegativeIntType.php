<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

/**
 * @api
 * @extends IntRangeType<negative-int>
 * @psalm-immutable
 */
readonly class NegativeIntType extends IntRangeType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct(rangeMax: -1);
    }

    public function __toString(): string
    {
        return 'negative-int';
    }
}

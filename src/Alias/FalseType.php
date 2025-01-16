<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\BoolType;

/**
 * @api
 * @extends BoolType<false>
 * @psalm-immutable
 */
readonly class FalseType extends BoolType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct(false);
    }
}

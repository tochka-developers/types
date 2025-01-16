<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Complex\UnionType;

/**
 * @api
 * @extends UnionType<int|string>
 * @psalm-immutable
 */
readonly class ArrayKeyType extends UnionType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct(new IntType(), new StringType());
    }

    public function __toString(): string
    {
        return 'array-key';
    }
}

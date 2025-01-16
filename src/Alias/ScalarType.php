<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\BoolType;
use Tochka\Types\Atomic\FloatType;
use Tochka\Types\Atomic\IntType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Complex\UnionType;

/**
 * @api
 * @extends UnionType<string|int|float|bool>
 * @psalm-immutable
 */
readonly class ScalarType extends UnionType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct(new StringType(), new IntType(), new FloatType(), new BoolType());
    }

    public function __toString(): string
    {
        return 'scalar';
    }
}

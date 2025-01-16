<?php

declare(strict_types=1);

namespace Tochka\Types\Misc;

use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\NullType;
use Tochka\Types\Complex\UnionType;
use Tochka\Types\TypeInterface;

/**
 * @template-covariant TType
 * @psalm-require-implements TypeInterface
 * @psalm-immutable
 */
trait DefaultNullable
{
    public function isNullable(): bool
    {
        return $this instanceof NullType || $this instanceof MixedType;
    }

    /**
     * @return TypeInterface<TType|null>
     */
    public function setNullable(): TypeInterface
    {
        if ($this->isNullable()) {
            return $this;
        }

        return new UnionType($this, new NullType());
    }
}

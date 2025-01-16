<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\NotType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Complex\IntersectType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @extends StringType<non-falsy-string>
 * @psalm-immutable
 */
readonly class NonFalsyStringType extends StringType
{
    public function isContravariantTo(TypeInterface $type): bool
    {
        $realType = new IntersectType(
            new NonEmptyStringType(),
            new NotType(new StringConstType('0')),
        );

        return $realType->isContravariantTo($type);
    }

    public function __toString(): string
    {
        return 'non-falsy-string';
    }
}

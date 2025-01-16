<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\NotType;
use Tochka\Types\Atomic\StringType;
use Tochka\Types\Complex\IntersectType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @extends StringType<non-empty-string>
 * @psalm-immutable
 */
readonly class NonEmptyStringType extends StringType
{
    public function isContravariantTo(TypeInterface $type): bool
    {
        $realType = new IntersectType(
            new StringType(),
            new NotType(new StringConstType('')),
        );

        return $realType->isContravariantTo($type);
    }

    public function __toString(): string
    {
        return 'non-empty-string';
    }
}

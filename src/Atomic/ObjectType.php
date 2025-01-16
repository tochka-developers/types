<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\Misc\KeyShapeItems;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @implements NamedTypeInterface<object>
 * @psalm-immutable
 */
readonly class ObjectType implements NamedTypeInterface
{
    /** @use DefaultNullable<object> */
    use DefaultNullable;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        public ?KeyShapeItems $shapeItems = null,
    ) {}

    public function isContravariantTo(TypeInterface $type): bool
    {
        // TODO: сделать строгую проверку по shape
        return $type instanceof ObjectType || $type instanceof ClassType;
    }

    public function __toString(): string
    {
        if ($this->shapeItems !== null) {
            return 'object{' . $this->shapeItems . '}';
        }

        return 'object';
    }

    public function toNativeTypeString(): string
    {
        return 'object';
    }
}

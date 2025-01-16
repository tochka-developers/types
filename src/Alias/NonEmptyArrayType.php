<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\ArrayType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\NeverType;
use Tochka\Types\Atomic\NotType;
use Tochka\Types\Complex\IntersectType;
use Tochka\Types\Misc\KeyShapeItems;
use Tochka\Types\Misc\ShapeItems;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of non-empty-array
 * @extends ArrayType<TType>
 * @psalm-immutable
 */
readonly class NonEmptyArrayType extends ArrayType
{
    /**
     * @template TValueType
     * @template TKeyType
     * @param TypeInterface<TValueType> $valueType
     * @param TypeInterface<TKeyType> $keyType
     * @psalm-this-out static<non-empty-array<TValueType, TKeyType>>
     * @codeCoverageIgnore
     */
    public function __construct(
        TypeInterface $valueType = new MixedType(),
        TypeInterface $keyType = new ArrayKeyType(),
        ShapeItems|KeyShapeItems|null $shapeItems = null,
    ) {
        parent::__construct($valueType, $keyType, $shapeItems);
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        $realType = new IntersectType(
            new ArrayType($this->valueType, $this->keyType),
            new NotType(new ArrayType(new NeverType())),
        );

        return $realType->isContravariantTo($type);
    }

    protected function getStringAlias(): string
    {
        return 'non-empty-array';
    }
}

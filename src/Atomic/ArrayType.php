<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Alias\ArrayKeyType;
use Tochka\Types\Alias\NonNegativeIntType;
use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\Misc\KeyShapeItem;
use Tochka\Types\Misc\KeyShapeItems;
use Tochka\Types\Misc\ShapeItem;
use Tochka\Types\Misc\ShapeItems;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of array
 * @implements NamedTypeInterface<TType>
 * @psalm-immutable
 */
readonly class ArrayType implements NamedTypeInterface
{
    /** @use DefaultNullable<TType> */
    use DefaultNullable;

    /**
     * @template TValueType
     * @template TKeyType
     * @param TypeInterface<TValueType> $valueType
     * @param TypeInterface<TKeyType> $keyType
     * @psalm-this-out static<array<TKeyType, TValueType>>
     * @codeCoverageIgnore
     */
    public function __construct(
        public TypeInterface $valueType = new MixedType(),
        public TypeInterface $keyType = new ArrayKeyType(),
        public ShapeItems|KeyShapeItems|null $shapeItems = null,
    ) {}

    public function isContravariantTo(TypeInterface $type): bool
    {
        if (!$type instanceof ArrayType) {
            return false;
        }



        if ($this->shapeItems === null) {
            if ($type->shapeItems !== null) {
                $shapeCovariantToTypes = $this->shapeItemsCovariantToKeyValue($type->shapeItems->shapeItems);

                if ($type->valueType instanceof NeverType) {
                    return $shapeCovariantToTypes;
                }

                return $shapeCovariantToTypes && $this->keyValueIsContravariantTo($type);
            } else {
                return $this->keyValueIsContravariantTo($type);
            }
        }

        if ($type->shapeItems === null) {
            return false;
        }

        $typeShapeItems = $type->shapeItems->shapeItems;

        foreach ($this->shapeItems->shapeItems as $key => $item) {
            $keyName = $item instanceof KeyShapeItem ? $item->keyName : $key;

            if (!array_key_exists($keyName, $typeShapeItems)) {
                if ($item->isOptional) {
                    continue;
                }

                return false;
            }

            if (!$item->valueType->isContravariantTo($typeShapeItems[$keyName]->valueType)) {
                return false;
            }

            unset($typeShapeItems[$keyName]);
        }

        if (count($typeShapeItems) !== 0) {
            return $this->shapeItemsCovariantToKeyValue($typeShapeItems);
        }

        return true;
    }

    private function keyValueIsContravariantTo(ArrayType $type): bool
    {
        return $this->valueType->isContravariantTo($type->valueType)
            && $this->keyType->isContravariantTo($type->keyType);
    }

    /**
     * @param array<ShapeItem|KeyShapeItem> $shapeItems
     * @return bool
     */
    private function shapeItemsCovariantToKeyValue(array $shapeItems): bool
    {
        foreach ($shapeItems as $shapeItem) {
            if (
                ($shapeItem instanceof KeyShapeItem && !$this->keyType->isContravariantTo(new StringType()))
                || ($shapeItem instanceof ShapeItem && !$this->keyType->isContravariantTo(new NonNegativeIntType()))
                || !$this->valueType->isContravariantTo($shapeItem->valueType)
            ) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        $keyString = (string) $this->keyType;
        $valueString = (string) $this->valueType;

        if ($this->shapeItems === null) {
            if ($this->valueType instanceof NeverType) {
                $restricts = '{}';
            } else {
                if ($this->keyType instanceof ArrayKeyType) {
                    if ($this->valueType instanceof MixedType) {
                        $restricts = '';
                    } else {
                        $restricts = "<{$valueString}>";
                    }
                } else {
                    $restricts = "<{$keyString}, {$valueString}>";
                }
            }
        } else {
            $restricts = $this->getRestrictsForShape($this->shapeItems);
        }

        return $this->getStringAlias() . $restricts;
    }

    /**
     * @return string
     */
    private function getRestrictsForShape(KeyShapeItems|ShapeItems $shapeItems): string
    {
        $shapeString = (string) $shapeItems;

        if (!$this->valueType instanceof NeverType) {
            if ($this->keyType instanceof ArrayKeyType && $this->valueType instanceof MixedType) {
                $shapeString .= ', ...';
            } else {
                $shapeString .= sprintf(', ...<%s, %s>', $this->keyType, $this->valueType);
            }
        }

        return '{' . $shapeString . '}';
    }

    protected function getStringAlias(): string
    {
        return 'array';
    }

    public function toNativeTypeString(): string
    {
        return 'array';
    }
}

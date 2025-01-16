<?php

declare(strict_types=1);

namespace Tochka\Types\Complex;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType
 * @implements TypeInterface<TType>
 * @psalm-immutable
 */
readonly class IntersectType implements TypeInterface
{
    /** @use DefaultNullable<TType> */
    use DefaultNullable;

    /** @var list<NamedTypeInterface<TType>> */
    public array $types;

    /**
     * @param NamedTypeInterface<TType> ...$types
     * @codeCoverageIgnore
     */
    public function __construct(NamedTypeInterface ...$types)
    {
        $this->types = array_values($types);
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        if ($type instanceof UnionType) {
            return $this->isAllOfUnionTypesCovariantToThis($type);
        }

        if (!$type instanceof IntersectType) {
            return $this->isAllOfThisTypesContravariantTo($type);
        }

        foreach ($this->types as $subType) {
            if (!$this->isOneOfIntersectTypesCovariantTo($type, $subType)) {
                return false;
            }
        }

        return true;
    }

    private function isAllOfUnionTypesCovariantToThis(UnionType $type): bool
    {
        foreach ($type->types as $subType) {
            if (!$this->isContravariantTo($subType)) {
                return false;
            }
        }

        return true;
    }

    private function isAllOfThisTypesContravariantTo(TypeInterface $type): bool
    {
        foreach ($this->types as $subType) {
            if (!$subType->isContravariantTo($type)) {
                return false;
            }
        }

        return true;
    }

    private function isOneOfIntersectTypesCovariantTo(IntersectType $intersectType, TypeInterface $type): bool
    {
        foreach ($intersectType->types as $subType) {
            if ($type->isContravariantTo($subType)) {
                return true;
            }
        }

        return false;
    }

    public function __toString(): string
    {
        return implode('&', array_map(fn(NamedTypeInterface $type) => (string) $type, $this->types));
    }

    public function toNativeTypeString(): string
    {
        return implode('&', array_map(fn(NamedTypeInterface $type) => $type->toNativeTypeString(), $this->types));
    }
}

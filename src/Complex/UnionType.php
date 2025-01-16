<?php

declare(strict_types=1);

namespace Tochka\Types\Complex;

use Tochka\Types\Atomic\NullType;
use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType
 * @implements TypeInterface<TType>
 * @psalm-immutable
 */
readonly class UnionType implements TypeInterface
{
    /** @use DefaultNullable<TType> */
    use DefaultNullable;

    /** @var list<NamedTypeInterface<TType> | IntersectType<TType>> */
    public array $types;

    /**
     * @param NamedTypeInterface<TType> | IntersectType<TType> ...$types
     * @codeCoverageIgnore
     */
    public function __construct(NamedTypeInterface|IntersectType ...$types)
    {
        $this->types = array_values($types);
    }

    /**
     * @return TypeInterface<TType|null>
     */
    public function setNullable(): TypeInterface
    {
        if ($this->isNullable()) {
            return $this;
        }

        return UnionType::mergeTypes($this, new NullType());
    }

    public function isNullable(): bool
    {
        return array_reduce(
            $this->types,
            fn(bool $carry, TypeInterface $item) => $carry || $item->isNullable(),
            false,
        );
    }

    /**
     * @template TTypesType
     * @param TypeInterface<TTypesType> ...$types
     * @return self<TTypesType>
     * @psalm-pure
     */
    public static function mergeTypes(TypeInterface ...$types): self
    {
        $resultTypes = [];
        foreach ($types as $type) {
            if ($type instanceof NamedTypeInterface || $type instanceof IntersectType) {
                $resultTypes[] = [$type];
            }
            if ($type instanceof UnionType) {
                $resultTypes[] = $type->types;
            }
        }

        return new self(...array_merge(...$resultTypes));
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        if (!$type instanceof UnionType) {
            return $this->isOneOfUnionTypesCovariantTo($type);
        }

        foreach ($type->types as $currentType) {
            if (!$this->isOneOfUnionTypesCovariantTo($currentType)) {
                return false;
            }
        }

        return true;
    }

    private function isOneOfUnionTypesCovariantTo(TypeInterface $type): bool
    {
        foreach ($this->types as $currentType) {
            if ($currentType->isContravariantTo($type)) {
                return true;
            }
        }

        return false;
    }

    public function __toString(): string
    {
        return implode('|', array_map(fn(TypeInterface $type) => (string) $type, $this->types));
    }

    public function toNativeTypeString(): string
    {
        return implode('|', array_map(fn(TypeInterface $type) => $type->toNativeTypeString(), $this->types));
    }
}

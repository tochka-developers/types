<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\ArrayType;
use Tochka\Types\Atomic\ClassType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Complex\UnionType;
use Tochka\Types\Misc\TemplateType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @extends UnionType<iterable>
 * @psalm-immutable
 */
readonly class IterableType extends UnionType
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        public TypeInterface $valueType = new MixedType(),
        public TypeInterface $keyType = new ArrayKeyType(),
    ) {
        $templateKeyType = new TemplateType($keyType);
        $templateValueType = new TemplateType($valueType, isCovariant: true);

        parent::__construct(
            new ArrayType($valueType, $keyType),
            new ClassType(\Traversable::class, [$templateKeyType, $templateValueType]),
        );
    }

    public function __toString(): string
    {
        $result = 'iterable';

        if ($this->keyType instanceof ArrayKeyType) {
            if ($this->valueType instanceof MixedType) {
                return $result;
            } else {
                return $result . '<' . $this->valueType . '>';
            }
        }

        return $result . '<' . $this->valueType . ', ' . $this->keyType . '>';
    }

    public function toNativeTypeString(): string
    {
        return 'iterable';
    }
}

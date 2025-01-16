<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\ArrayType;
use Tochka\Types\Atomic\MixedType;
use Tochka\Types\Atomic\NeverType;
use Tochka\Types\Misc\ShapeItems;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of list
 * @extends ArrayType<TType>
 * @psalm-immutable
 */
readonly class ListType extends ArrayType
{
    /**
     * @template TValueType
     * @param TypeInterface<TValueType> $valueType
     * @psalm-this-out static<list<TValueType>>
     * @codeCoverageIgnore
     */
    public function __construct(
        TypeInterface $valueType = new MixedType(),
        ?ShapeItems $shapeItems = null,
    ) {
        parent::__construct($valueType, new NonNegativeIntType(), $shapeItems);
    }

    public function __toString(): string
    {
        $valueString = (string) $this->valueType;

        if ($this->shapeItems === null) {
            if ($this->valueType instanceof NeverType) {
                $restricts = '{}';
            } else {
                if ($this->valueType instanceof MixedType) {
                    $restricts = '';
                } else {
                    $restricts = "<{$valueString}>";
                }
            }
        } else {
            /** @psalm-suppress PossiblyInvalidArgument В shapeItems всегда ShapeItems, потому что в конструкторе ограничения */
            $restricts = $this->getRestrictsForShape($this->shapeItems);
        }

        return $this->getStringAlias() . $restricts;
    }

    private function getRestrictsForShape(ShapeItems $shapeItems): string
    {
        $shapeString = (string) $shapeItems;

        if (!$this->valueType instanceof NeverType) {
            if ($this->valueType instanceof MixedType) {
                $shapeString .= ', ...';
            } else {
                $shapeString .= sprintf(', ...<%s>', $this->valueType);
            }
        }

        return '{' . $shapeString . '}';
    }

    protected function getStringAlias(): string
    {
        return 'list';
    }
}

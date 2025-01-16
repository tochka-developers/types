<?php

declare(strict_types=1);

namespace Tochka\Types\Misc;

/**
 * @api
 * @psalm-immutable
 */
readonly class ShapeItems implements \Stringable
{
    /** @var list<ShapeItem> */
    public array $shapeItems;

    public function __construct(ShapeItem $shapeItem, ShapeItem ...$shapeItems)
    {
        $this->shapeItems = array_values(
            array_merge([$shapeItem], $shapeItems),
        );
    }

    public function __toString(): string
    {
        $hasOptional = false;
        foreach ($this->shapeItems as $shapeItem) {
            if ($shapeItem->isOptional) {
                $hasOptional = true;
                break;
            }
        }

        $items = [];
        foreach ($this->shapeItems as $key => $shapeItem) {
            $items[] = $hasOptional
                ? $key . ($shapeItem->isOptional ? '?: ' : ': ') . $shapeItem->valueType
                : (string) $shapeItem->valueType;
        }

        return implode(', ', $items);
    }
}

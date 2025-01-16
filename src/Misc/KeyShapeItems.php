<?php

declare(strict_types=1);

namespace Tochka\Types\Misc;

/**
 * @api
 * @psalm-immutable
 */
readonly class KeyShapeItems
{
    /** @var array<string, KeyShapeItem> */
    public array $shapeItems;

    public function __construct(KeyShapeItem $shapeItem, KeyShapeItem ...$shapeItems)
    {
        $items = [];
        $items[$shapeItem->keyName] = $shapeItem;
        foreach ($shapeItems as $item) {
            $items[$item->keyName] = $item;
        }

        $this->shapeItems = $items;
    }

    public function __toString(): string
    {
        $items = [];
        foreach ($this->shapeItems as $shapeItem) {
            $items[] = $shapeItem->keyName . ($shapeItem->isOptional ? '?: ' : ': ') . $shapeItem->valueType;
        }

        return implode(', ', $items);
    }
}

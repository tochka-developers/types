<?php

declare(strict_types=1);

namespace Tochka\Types\Atomic;

use Tochka\Types\Misc\DefaultNullable;
use Tochka\Types\Misc\TemplateType;
use Tochka\Types\NamedTypeInterface;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TType of object
 * @implements NamedTypeInterface<TType>
 * @psalm-immutable
 */
readonly class ClassType implements NamedTypeInterface
{
    /** @use DefaultNullable<TType> */
    use DefaultNullable;

    /** @var class-string<TType> */
    public string $className;

    /**
     * @param class-string<TType> $className
     * @param list<TemplateType> $templateTypes\
     * @codeCoverageIgnore
     */
    public function __construct(
        string $className,
        public ?array $templateTypes = null,
    ) {
        /** @psalm-suppress PropertyTypeCoercion */
        $this->className = trim($className, '\\');
    }

    public function __toString(): string
    {
        $result = $this->toNativeTypeString();

        if ($this->templateTypes === null || count($this->templateTypes) === 0) {
            return $result;
        }

        $genericTypes = implode(
            ', ',
            array_map(fn(TemplateType $type) => (string) $type->type, $this->templateTypes),
        );

        return $result . '<' . $genericTypes . '>';
    }

    public function toNativeTypeString(): string
    {
        return $this->className;
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        if (!$type instanceof ClassType) {
            return false;
        }

        if (!is_a($type->className, $this->className, true)) {
            return false;
        }

        if ($this->templateTypes === null || count($this->templateTypes) === 0) {
            return true;
        }

        if ($type->templateTypes === null || count($this->templateTypes) !== count($type->templateTypes)) {
            return false;
        }

        for ($i = 0; $i < count($this->templateTypes); $i++) {
            if (!$this->templateTypes[$i]->isContravariantTo($type->templateTypes[$i])) {
                return false;
            }
        }

        return true;
    }
}

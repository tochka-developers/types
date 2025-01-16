<?php

declare(strict_types=1);

namespace Tochka\Types\Alias;

use Tochka\Types\Atomic\StringType;
use Tochka\Types\TypeInterface;

/**
 * @api
 * @template-covariant TClassName of object
 * @template-extends StringType<class-string<TClassName>>
 * @psalm-immutable
 */
readonly class ClassStringType extends StringType
{
    /**
     * @psalm-param class-string<TClassName>|null $className
     * @codeCoverageIgnore
     */
    public function __construct(
        public ?string $className = null,
    ) {}

    public function __toString(): string
    {
        return 'class-string' . ($this->className !== null ? '<' . $this->className . '>' : '');
    }

    public function isContravariantTo(TypeInterface $type): bool
    {
        if (!$type instanceof ClassStringType) {
            return false;
        }

        return $this->className === null
            || ($type->className !== null && is_a($type->className, $this->className, true));
    }
}

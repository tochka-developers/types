<?php

declare(strict_types=1);

namespace Tochka\Types;

/**
 * @api
 * @template-covariant TType
 * @extends TypeInterface<TType>
 * @psalm-immutable
 */
interface NamedTypeInterface extends TypeInterface {}

<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Collection;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Collection<Schema>
 */
class PolymorphicSchemas extends Collection implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof Schema;
	}
}

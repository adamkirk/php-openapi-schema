<?php

declare(strict_types=1);

namespace OpenApiSchema\Components;

use OpenApiSchema\Spec\Dictionary;
use OpenApiSchema\Reference;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Dictionary<Example|Reference>
 */
class Examples extends Dictionary implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof Example || $value instanceof Reference;
	}
}

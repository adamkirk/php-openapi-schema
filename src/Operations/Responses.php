<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Dictionary;
use OpenApiSchema\Reference;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Dictionary<Response|Reference>
 */
class Responses extends Dictionary implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof Response || $value instanceof Reference;
	}
}

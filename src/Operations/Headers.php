<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Reference;
use OpenApiSchema\Spec\Collection;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Collection<Header|Reference>
 */
class Headers extends Collection implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof Header || $value instanceof Reference;
	}
}

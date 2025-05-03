<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Dictionary;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Dictionary<MediaType>
 */
class Content extends Dictionary implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof MediaType;
	}
}

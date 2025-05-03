<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

/**
 * @extends Dictionary<string>
 */
class StringDictionary extends Dictionary implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return is_string($value);
	}
}

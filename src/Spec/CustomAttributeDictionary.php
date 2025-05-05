<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

/**
 * @extends Dictionary<mixed>
 */
class CustomAttributeDictionary extends Dictionary
{
	protected static function isType(mixed $value): bool
	{
		return true;
	}
}

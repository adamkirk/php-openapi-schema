<?php

declare(strict_types=1);

namespace OpenApiSchema\Meta;

use OpenApiSchema\Spec\Collection;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Collection<Tag>
 */
class Tags extends Collection implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof Tag;
	}
}

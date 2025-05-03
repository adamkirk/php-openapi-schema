<?php

declare(strict_types=1);

namespace OpenApiSchema\Server;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\Collection;

/**
 * @extends Collection<Server>
 */
class Servers extends Collection implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof Server;
	}
}

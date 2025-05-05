<?php

declare(strict_types=1);

namespace OpenApiSchema\Server;

use OpenApiSchema\Spec\Dictionary;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Dictionary<ServerVariable>
 */
class ServerVariables extends Dictionary implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof ServerVariable;
	}
}

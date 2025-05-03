<?php

declare(strict_types=1);

namespace OpenApiSchema\Security;

use OpenApiSchema\Spec\Dictionary;
use OpenApiSchema\Spec\Marshallable;

/**
 * @extends Dictionary<SecurityRequirement>
 */
class SecurityRequirements extends Dictionary implements Marshallable
{
	protected static function isType(mixed $value): bool
	{
		return $value instanceof SecurityRequirement;
	}
}

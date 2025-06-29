<?php

declare(strict_types=1);

namespace Tests\Unit\Spec\Stubs;

use OpenApiSchema\Spec\CustomAttributeDictionary;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class MarshallableWithCustomAttributes
{
	use ConvertsSelfToMarshallable;

	public function __construct(
		protected CustomAttributeDictionary $customAttributes,
		protected ?string $someString,
	) {}
}

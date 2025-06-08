<?php

declare(strict_types=1);

namespace Tests\Unit\Spec\Stubs;

use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\CustomAttributeDictionary;

class HasCustomAttributesStub
{
	use HasCustomAttributes;

	/**
	 * Just return the value so we can verify the behaviour of the trait...
	 */
	public function getCustomAttributes(): ?CustomAttributeDictionary
	{
		return $this->customAttributes;
	}
}

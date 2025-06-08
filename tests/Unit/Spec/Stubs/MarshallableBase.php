<?php

declare(strict_types=1);

namespace Tests\Unit\Spec\Stubs;

use OpenApiSchema\Spec\Collection;
use OpenApiSchema\Spec\Dictionary;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class MarshallableBase
{
	use ConvertsSelfToMarshallable;

	public function __construct(
		protected Collection $someCollection,
		protected array $someArray,
		protected Dictionary $someDict,
		protected ?string $someString,
	) {}
}

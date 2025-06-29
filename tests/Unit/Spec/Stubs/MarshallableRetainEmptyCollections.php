<?php

declare(strict_types=1);

namespace Tests\Unit\Spec\Stubs;

class MarshallableRetainEmptyCollections extends MarshallableBase
{
	protected function omitEmptyCollections(): bool
	{
		return false;
	}
}

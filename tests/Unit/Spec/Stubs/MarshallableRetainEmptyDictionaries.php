<?php

declare(strict_types=1);

namespace Tests\Unit\Spec\Stubs;

class MarshallableRetainEmptyDictionaries extends MarshallableBase
{
	protected function omitEmptyDictionaries(): bool
	{
		return false;
	}
}

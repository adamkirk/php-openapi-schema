<?php

declare(strict_types=1);

namespace Tests\Unit\Spec\Stubs;

class MarshallableArrayWhenEmpty extends MarshallableBase
{
	protected function useJsonObjectWhenEmpty(): bool
	{
		return false;
	}
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Spec;

use PHPUnit\Framework\TestCase;
use OpenApiSchema\Spec\MarshallingContext;

/**
 * @covers MarshallingContext
 */
class MarshallingContextTest extends TestCase
{
	public function test_defaults_for_get(): void
	{
		$subject = new MarshallingContext();

		$this->assertNull($subject->get('blah'));
		$this->assertEquals('meh', $subject->get('blah', 'meh'));
	}

	public function test_setting_values(): void
	{
		$subject = new MarshallingContext();

		$this->assertNull($subject->get('blah'));
		$subject->set('blah', 'meh');
		$this->assertEquals('meh', $subject->get('blah'));

		$subject->setIfNotExists('blah', 'blah');
		// Value shouldn't change cause the key is already set
		$this->assertEquals('meh', $subject->get('blah'));

		$subject->setIfNotExists('newvalue', 1234);
		$this->assertEquals(1234, $subject->get('newvalue'));
	}
}

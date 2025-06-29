<?php

declare(strict_types=1);

namespace Tests\Unit\Spec;

use OpenApiSchema\Reference;
use PHPUnit\Framework\TestCase;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\MarshallingContext;

/**
 * @covers Reference
 */
class ReferenceTest extends TestCase
{
	public function test_initialization()
	{
		$ref = new Reference();

		$this->assertNull($ref->getSummary());
		$this->assertNull($ref->getDescription());
		$this->assertNull($ref->getRef());

		$this->assertInstanceOf(Marshallable::class, $ref);

	}

	public function test_getters_and_setters()
	{
		$ref = new Reference();

		$ref->setSummary('summary');
		$ref->setDescription('description');
		$ref->setRef('ref');

		$this->assertEquals('summary', $ref->getSummary());
		$this->assertEquals('description', $ref->getDescription());
		$this->assertEquals('ref', $ref->getRef());
	}

	public function test_its_marshallable()
	{
		$ref = new Reference();

		$ref->setSummary('summary');
		$ref->setDescription('description');
		$ref->setRef('ref');

		/** @var MockObject|MarshallingContext */
		$ctx = $this->createMock(MarshallingContext::class);

		$res = $ref->toMarshallable($ctx);

		$this->assertEquals([
			'description' => 'description',
			'summary' => 'summary',
			'$ref' => 'ref',
		], $res);
	}
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Spec;

use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use OpenApiSchema\Spec\Collection;
use OpenApiSchema\Spec\MarshallingContext;
use Tests\Unit\Spec\Stubs\StringCollection;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @covers Collection
 */
class CollectionTest extends TestCase
{
	public function test_is_empty(): void
	{
		$coll = new StringCollection();
		$this->assertTrue($coll->isEmpty());

		$coll->add("blah");

		$this->assertFalse($coll->isEmpty());
	}


	/**
	 * @dataProvider invalidTypes
	 */
	public function test_adding_invalid_types(mixed $val): void
	{
		$this->expectExceptionObject(
			new InvalidArgumentException('incorrect type for ' . StringCollection::class),
		);
		$coll = new StringCollection();

		/** @phpstan-ignore argument.type */
		$coll->add($val);
	}

	public static function invalidTypes(): Generator
	{
		yield "int" => [1234];
		yield "bool" => [true];
		yield "array" => [["some", "array"]];
	}

	public function test_to_marshallable(): void
	{
		$ctx = $this->createMock(MarshallingContext::class);
		$coll = new StringCollection();
		$coll->add("some");
		$coll->add("strings");

		$this->assertEquals(
			["some", "strings"],
			$coll->toMarshallable($ctx),
		);
	}
}

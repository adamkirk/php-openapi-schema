<?php

declare(strict_types=1);

namespace Tests\Unit\Spec;

use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use OpenApiSchema\Spec\StringDictionary;
use OpenApiSchema\Spec\MarshallingContext;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * This actually covers base functionality of the abstract and this specific
 * implementation. I don't like them being done together, but to test the abstract
 * I wrote a stub that was identical to StringDictionary anyway, so bit pointless
 * testing an identical class twice.
 *
 * @covers Dictionary
 * @covers StringDictionary
 */
class StringDictionaryTest extends TestCase
{
	public function test_is_empty(): void
	{
		$dict = new StringDictionary();
		$this->assertTrue($dict->isEmpty());

		$dict->add("key", "value");

		$this->assertFalse($dict->isEmpty());
	}

	/**
	 * @dataProvider invalidTypes
	 */
	public function test_adding_invalid_types(mixed $val): void
	{
		$this->expectExceptionObject(
			new InvalidArgumentException('incorrect type for ' . StringDictionary::class),
		);
		$dict = new StringDictionary();

		/** @phpstan-ignore argument.type */
		$dict->add("key", $val);
	}

	public static function invalidTypes(): Generator
	{
		yield "int" => [1234];
		yield "bool" => [true];
		yield "array" => [["some", "array"]];
	}

	public function test_has(): void
	{
		$dict = new StringDictionary();
		$dict->add("key1", "some");
		$dict->add("key2", "strings");

		$this->assertTrue($dict->has('key1'));
		$this->assertTrue($dict->has('key2'));

		$this->assertFalse($dict->has('missing'));
	}

	public function test_get(): void
	{
		$dict = new StringDictionary();
		$dict->add("key1", "some");
		$dict->add("key2", "strings");

		$this->assertEquals('some', $dict->get('key1'));
		$this->assertEquals('strings', $dict->get('key2'));

		$this->assertNull($dict->get('missing'));
		$this->assertEquals('somedefault', $dict->get('missing', 'somedefault'));
	}

	public function test_to_marshallable(): void
	{
		/** @var MarshallingContext|MockObject */
		$ctx = $this->createMock(MarshallingContext::class);
		$dict = new StringDictionary();
		$dict->add("key1", "some");
		$dict->add("key2", "strings");

		$this->assertEquals(
			["key1" => "some", "key2" => "strings"],
			$dict->toMarshallable($ctx),
		);
	}

	public function test_can_iterate(): void
	{
		$dict = new StringDictionary();
		$dict->add("key1", "some");
		$dict->add("key2", "strings");

		$values = [];
		foreach ($dict as $key => $value) {
			$values[$key] = $value;
		}

		$this->assertEquals([
			'key1' => 'some',
			'key2' => 'strings',
		], $values);
	}
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Spec;

use stdClass;
use Generator;
use PHPUnit\Framework\TestCase;
use OpenApiSchema\Spec\Collection;
use OpenApiSchema\Spec\Dictionary;
use OpenApiSchema\Spec\MarshallingContext;
use Tests\Unit\Spec\Stubs\MarshallableBase;
use PHPUnit\Framework\MockObject\MockObject;
use OpenApiSchema\Spec\CustomAttributeDictionary;
use Tests\Unit\Spec\Stubs\MarshallableArrayWhenEmpty;
use Tests\Unit\Spec\Stubs\MarshallableRetainEmptyArrays;
use Tests\Unit\Spec\Stubs\MarshallableWithCustomAttributes;
use Tests\Unit\Spec\Stubs\MarshallableRetainEmptyCollections;

/**
 * @covers ConvertsSelfToMarshallable
 */
class ConvertsSelfToMarshallableTest extends TestCase
{
	/**
	 * @dataProvider scenarios
	 */
	public function test_to_marshallable(callable $buildSubject, array|stdClass $expect): void
	{
		/** ConvertsSelfToMarshallable $subject */
		$subject = $buildSubject($this);

		$ctx = $this->createMock(MarshallingContext::class);
		$output = $subject->toMarshallable($ctx);

		$this->assertEqualsCanonicalizing($expect, $output);
	}

	public static function scenarios(): Generator
	{
		yield 'everything populated' => [
			function (self $test) {
				/** @var Collection|MockObject $collection */
				$collection = $test->createMock(Collection::class);
				$collection->expects($test->any())->method('isEmpty')->willReturn(false);
				$collection->expects($test->any())->method('toMarshallable')->willReturn([
					'my-collection',
				]);

				/** @var Dictionary|MockObject $dict */
				$dict = $test->createMock(Dictionary::class);
				$dict->expects($test->any())->method('isEmpty')->willReturn(false);
				$dict->expects($test->any())->method('toMarshallable')->willReturn([
					'my' => 'dict',
				]);

				return new MarshallableBase(
					$collection,
					[
						'some-array',
					],
					$dict,
					'some-string',
				);
			},
			[
				'someCollection' => [
					'my-collection',
				],
				'someArray' => [
					'some-array',
				],
				'someDict' => [
					'my' => 'dict',
				],
				'someString' => 'some-string',
			],
		];

		yield 'all collections/dictionaries are empty' => [
			function (self $test) {
				/** @var Collection|MockObject $collection */
				$collection = $test->createMock(Collection::class);
				$collection->expects($test->any())->method('isEmpty')->willReturn(true);

				/** @var Dictionary|MockObject $dict */
				$dict = $test->createMock(Dictionary::class);
				$dict->expects($test->any())->method('isEmpty')->willReturn(true);

				return new MarshallableBase(
					$collection,
					[],
					$dict,
					'some-string',
				);
			},
			[
				'someString' => 'some-string',
			],
		];

		yield 'everything is empty' => [
			function (self $test) {
				/** @var Collection|MockObject $collection */
				$collection = $test->createMock(Collection::class);
				$collection->expects($test->any())->method('isEmpty')->willReturn(true);

				/** @var Dictionary|MockObject $dict */
				$dict = $test->createMock(Dictionary::class);
				$dict->expects($test->any())->method('isEmpty')->willReturn(true);

				return new MarshallableBase(
					$collection,
					[],
					$dict,
					null,
				);
			},
			new stdClass(),
		];

		yield 'empty collections are not omitted' => [
			function (self $test) {
				/** @var Collection|MockObject $collection */
				$collection = $test->createMock(Collection::class);
				$collection->expects($test->any())->method('isEmpty')->willReturn(true);

				/** @var Dictionary|MockObject $dict */
				$dict = $test->createMock(Dictionary::class);
				$dict->expects($test->any())->method('isEmpty')->willReturn(true);

				return new MarshallableRetainEmptyCollections(
					$collection,
					[],
					$dict,
					null,
				);
			},
			[
				'someCollection' => [],
			],
		];

		yield 'empty arrays are not omitted' => [
			function (self $test) {
				/** @var Collection|MockObject $collection */
				$collection = $test->createMock(Collection::class);
				$collection->expects($test->any())->method('isEmpty')->willReturn(true);

				/** @var Dictionary|MockObject $dict */
				$dict = $test->createMock(Dictionary::class);
				$dict->expects($test->any())->method('isEmpty')->willReturn(true);

				return new MarshallableRetainEmptyArrays(
					$collection,
					[],
					$dict,
					null,
				);
			},
			[
				'someArray' => [],
			],
		];

		yield 'empty dictionaires are not omitted' => [
			function (self $test) {
				/** @var Collection|MockObject $collection */
				$collection = $test->createMock(Collection::class);
				$collection->expects($test->any())->method('isEmpty')->willReturn(true);

				/** @var Dictionary|MockObject $dict */
				$dict = $test->createMock(Dictionary::class);
				$dict->expects($test->any())->method('isEmpty')->willReturn(true);

				return new MarshallableRetainEmptyArrays(
					$collection,
					[],
					$dict,
					null,
				);
			},
			[
				'someDict' => [],
			],
		];

		yield 'overrides to return array when empty' => [
			function (self $test) {
				/** @var Collection|MockObject $collection */
				$collection = $test->createMock(Collection::class);
				$collection->expects($test->any())->method('isEmpty')->willReturn(true);

				/** @var Dictionary|MockObject $dict */
				$dict = $test->createMock(Dictionary::class);
				$dict->expects($test->any())->method('isEmpty')->willReturn(true);

				return new MarshallableArrayWhenEmpty(
					$collection,
					[],
					$dict,
					null,
				);
			},
			[],
		];

		yield 'custom attributes are included' => [
			function (self $test) {
				/** @var CustomAttributeDictionary|MockObject $custom */
				$custom = $test->createMock(CustomAttributeDictionary::class);
				$custom->expects($test->any())->method('toMarshallable')->willReturn([
					'custom' => 'attribute',
				]);

				return new MarshallableWithCustomAttributes(
					$custom,
					'some-string',
				);
			},
			[
				'someString' => 'some-string',
				'custom' => 'attribute',
			],
		];

		yield 'custom attribute overrides class property' => [
			function (self $test) {
				/** @var CustomAttributeDictionary|MockObject $custom */
				$custom = $test->createMock(CustomAttributeDictionary::class);
				$custom->expects($test->any())->method('toMarshallable')->willReturn([
					'someString' => 'my-override',
				]);

				return new MarshallableWithCustomAttributes(
					$custom,
					'some-string',
				);
			},
			[
				'someString' => 'my-override',
			],
		];

		yield 'custom attribute with ref prop is prefixed with $' => [
			function (self $test) {
				/** @var CustomAttributeDictionary|MockObject $custom */
				$custom = $test->createMock(CustomAttributeDictionary::class);
				$custom->expects($test->any())->method('toMarshallable')->willReturn([
					'ref' => 'blah',
				]);

				return new MarshallableWithCustomAttributes(
					$custom,
					'some-string',
				);
			},
			[
				'someString' => 'some-string',
				'$ref' => 'blah',
			],
		];
	}
}

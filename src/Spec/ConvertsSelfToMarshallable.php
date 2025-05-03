<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

use stdClass;
use RuntimeException;

/**
 * Provides utility functions that can convert the using object into a
 * "marshallable" data structure.
 *
 * @see OpenApiSchema\Spec\Marshallable
 */
trait ConvertsSelfToMarshallable
{
	/**
	 * This changes the behaviour of toMarshallable so that it will return a
	 * new stdClass instead of an empty array, in the scenario that the using class
	 * doesn't have any non-empty properties.
	 *
	 * Primarily this is useful for top level openapi fields like 'components',
	 * where it's easier to set `"components": {}` rather than omit it completely
	 * from the spec.
	 */
	protected function useJsonObjectWhenEmpty(): bool
	{
		return true;
	}

	/**
	 * This changes the behaviour of toMarshallable so that if it comes across
	 * a value that is a type of OpenApiSchema\Spec\Collection, instead of including
	 * the property as an empty array, the key where the value was found will be
	 * omitted completely from the marshallable data structure.
	 */
	protected function omitEmptyCollections(): bool
	{
		return true;
	}

	/**
	 * This changes the behaviour of toMarshallable so that if it comes across
	 * a value that is an array (i.e. is_array($value) == true), instead of including
	 * the property as an empty array, the key where the value was found will be
	 * omitted completely from the marshallable data structure.
	 */
	protected function omitEmptyArrays(): bool
	{
		return true;
	}

	/**
	 * This changes the behaviour of toMarshallable so that if it comes across
	 * a value that is an instance of Dictionary, instead of including the
	 * property as an empty array, the key where the value was found will be
	 * omitted completely from the marshallable data structure.
	 */
	protected function omitEmptyDictionaries(): bool
	{
		return true;
	}

	protected function shouldOmit(mixed $val): bool
	{
		return match (true) {
			$val === null,
			$val instanceof Collection && $this->omitEmptyCollections() && $val->isEmpty(),
			$val instanceof Dictionary && $this->omitEmptyDictionaries() && $val->isEmpty(),
			is_array($val) && $this->omitEmptyArrays() && empty($val)
				=> true,
			default => false,
		};
	}

	/**
	 * Converts this class to a marshallable data structure. This will typically
	 * return an array by looping through the properties of the object using the
	 * property name as the key, and the value.
	 *
	 * It gives us a little more flexibility than if we simply called json_encode()
	 * or similar on the object, as we can decide whether to omit the params in
	 * certain scenarios.
	 *
	 * We also account for custom attributes in here, and if there are any we
	 * do an array_merge with the rest of the data structure, giving priority
	 * to the custom attributes. This does mean that we can use custom attributes
	 * to change the entire data structure if needed; this seems like a nice way
	 * to cover edge cases that aren't supported explicitly by the objects.
	 *
	 * Pretty much every class in this library will use this function.
	 *
	 * Note: there is a special case made here for the '$ref' property as this
	 * can be found in a lot of places, but the name of the property in the actual
	 * class can't be '$ref', so we override the key to '$ref' in the output if
	 * property is named 'ref'.
	 *
	 * @return mixed[]|stdClass
	 */
	public function toMarshallable(MarshallingContext $ctx): array|stdClass
	{
		$output = [];

		$customAttributes = [];

		/**
		 * This is valid php, but phpstan doesn't like iterating through an
		 * object.
		 *
		 * @phpstan-ignore foreach.nonIterable
		 */
		foreach ($this as $key => $val) {
			if ($val instanceof CustomAttributeDictionary) {
				if ($val->toMarshallable($ctx) instanceof stdClass) {
					// This shouldn't really be possible, but the type system would allow it.
					// Partially here to satisfy phpstan...
					throw new RuntimeException("Got stdClass from CustomAttributeDictionary");
				}
				$customAttributes = $val->toMarshallable($ctx);
				continue;
			}

			if ($this->shouldOmit($val)) {
				continue;
			}

			if ($val instanceof Marshallable) {
				$val = $val->toMarshallable($ctx);
			}

			$key = match ($key) {
				"ref" => '$ref',
				default => $key,
			};

			$output[$key] = $val;
		}

		$allProps = array_merge($output, $customAttributes);

		if (empty($allProps) && $this->useJsonObjectWhenEmpty()) {
			return new stdClass();
		}

		return $allProps;
	}
}

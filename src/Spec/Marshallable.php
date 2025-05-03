<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

use stdClass;

/**
 * Signifies the class can be converted to a Marshallable data structure. In this
 * context a "Marshallable" data structure, is either an array or an stdClass.
 * It's something that can be given to "marshaller" for a predictable output.
 *
 * This makes it simpler to convert the overall document into a predictable structure
 * rather than using objects.
 *
 * We include stdClass as an option as sometimes, when a class is "empty", we wanna
 * include it in the spec as '{}', and stdClass is the easiest way to achieve that.
 */
interface Marshallable
{
	/**
	 * @return mixed[]|stdClass
	 */
	public function toMarshallable(MarshallingContext $ctx): array|stdClass;
}

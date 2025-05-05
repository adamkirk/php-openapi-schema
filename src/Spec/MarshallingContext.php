<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

/**
 * Used to pass/retain values throughout the marshalling process. It will be
 * passed to each toMarshallable function on each object.
 *
 * The main idea behind this context is to allow modification of the marshalling
 * process without changing much of the original implementation of the classes.
 *
 * @property CustomAttributeDictionary $customAttributes
 */
class MarshallingContext
{
	use HasCustomAttributes;

	public function __construct()
	{
		$this->customAttributes = new CustomAttributeDictionary();
	}

	public function get(string $key, mixed $default = null): mixed
	{
		return $this->customAttributes->get($key, $default);
	}

	public function set(string $key, mixed $value): mixed
	{
		return $this->customAttributes->add($key, $value);
	}

	/**
	 * Note, this will not set anything if the key is found but has a null value.
	 *
	 * @see OpenApiSchema\Spec\Dictionary has
	 */
	public function setIfNotExists(string $key, mixed $value): void
	{
		if ($this->customAttributes->has($key)) {
			return;
		}

		$this->customAttributes->add($key, $value);
	}
}

<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

trait HasCustomAttributes
{
	/**
	 * This property is lazily initialized by the addCustomAttribute method, so
	 * that we don't need to initialise this in the constructors of each class
	 * that use this trait.
	 *
	 * It does mean that the type is nullable, but the using side doesn't have to
	 * worry about instantiation.
	 */
	protected ?CustomAttributeDictionary $customAttributes = null;

	/**
	 * When adding a custom attribute, it's up to the user adding the attribute
	 * to make sure it works as a "Marshallable thing". The dictionary used will
	 * go through the same marshalling logic as everything else, (see
	 * ConvertsSelfToMarshallable), so simply implementing the Marshallable
	 * interface in anything you set should ensure that it is marshalled how you
	 * expect. Or you can just provide scalar values.
	 */
	public function addCustomAttribute(string $key, mixed $value): static
	{
		if ($this->customAttributes === null) {
			$this->customAttributes = new CustomAttributeDictionary();
		}

		$this->customAttributes->add($key, $value);

		return $this;
	}
}

<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Parameter implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected string $name;

	// TODO: enum for this (query, header, path, cookie)
	protected string $in;

	protected ?string $description;

	protected ?bool $required;

	protected ?bool $deprecated;

	protected ?bool $allowEmptyValue;

	protected ?Schema $schema;

	protected ?string $style;

	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function setIn(string $in): self
	{
		$this->in = $in;
		return $this;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setRequired(bool $required): self
	{
		$this->required = $required;
		return $this;
	}

	/** @deprecated use setRequired */
	public function isRequired(): self
	{
		$this->required = true;
		return $this;
	}

	/** @deprecated use setRequired */
	public function isNotRequired(): self
	{
		$this->required = false;
		return $this;
	}

	public function setAllowsEmptyValue(bool $allowed): self
	{
		$this->allowEmptyValue = $allowed;
		return $this;
	}

	/** @deprecated use setAllowsEmptyValue */
	public function allowsEmptyValue(): self
	{
		$this->allowEmptyValue = true;
		return $this;
	}

	/** @deprecated use setAllowsEmptyValue */
	public function doesNotAllowEmptyValue(): self
	{
		$this->allowEmptyValue = false;
		return $this;
	}

	public function setSchema(Schema $schema): self
	{
		$this->schema = $schema;
		return $this;
	}

	public function setStyle(?string $style): self
	{
		$this->style = $style;
		return $this;
	}

}

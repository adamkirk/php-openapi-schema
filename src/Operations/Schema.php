<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Schema implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $ref;

	protected ?string $description;

	/** @var string[] $required */
	protected array $required;

	protected ?bool $writeOnly;
	protected ?bool $readOnly;

	protected ?string $type;
	protected ?string $format;
	protected ?int $exclusiveMaximum;
	protected ?int $exclusiveMinimum;

	/** @var string[] $enum */
	protected array $enum;

	protected ?Schema $items;

	protected Schemas $properties;

	// Not sure if there is a strict schema for this, can be all sorts...
	protected mixed $examples;

	public function __construct()
	{
		$this->required = [];
		$this->enum = [];
		$this->properties = new Schemas();
	}

	public function setRef(string $ref): self
	{
		$this->ref = $ref;
		return $this;
	}

	public function setType(string $type): self
	{
		$this->type = $type;
		return $this;
	}

	public function setFormat(string $format): self
	{
		$this->format = $format;
		return $this;
	}

	public function setItems(Schema $items): self
	{
		$this->items = $items;
		return $this;
	}

	public function setExamples(mixed $examples): self
	{
		$this->examples = $examples;
		return $this;
	}

	public function setExclusiveMaximum(int $exclusiveMaximum): self
	{
		$this->exclusiveMaximum = $exclusiveMaximum;
		return $this;
	}

	public function setExclusiveMinimum(int $exclusiveMinimum): self
	{
		$this->exclusiveMinimum = $exclusiveMinimum;
		return $this;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function markFieldsAsRequired(string ...$fields): self
	{
		$this->required = array_unique(
			array_merge($this->required, $fields),
		);

		return $this;
	}

	public function isWriteOnly(): self
	{
		$this->writeOnly = true;
		return $this;
	}

	public function isNotWriteOnly(): self
	{
		$this->writeOnly = false;
		return $this;
	}


	public function isReadOnly(): self
	{
		$this->readOnly = true;
		return $this;
	}

	public function isNotReadOnly(): self
	{
		$this->readOnly = false;
		return $this;
	}

	public function addProperty(string $key, Schema $property): self
	{
		$this->properties->add($key, $property);
		return $this;
	}

	public function addEnumCases(string ...$cases): self
	{
		$this->enum = array_merge($this->enum, $cases);
		return $this;
	}
}

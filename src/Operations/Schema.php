<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Schema implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $ref;

	protected ?string $description = null;

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

	protected ?bool $nullable;

	protected ?Schema $items;

	protected Schemas $properties;

	protected PolymorphicSchemas $oneOf;
	protected PolymorphicSchemas $anyOf;
	protected PolymorphicSchemas $allOf;

	// Not sure if there is a strict schema for this, can be all sorts...
	protected mixed $examples;

	public function __construct()
	{
		$this->required = [];
		$this->enum = [];
		$this->properties = new Schemas();
		$this->oneOf = new PolymorphicSchemas();
		$this->anyOf = new PolymorphicSchemas();
		$this->allOf = new PolymorphicSchemas();
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

	public function addOneOfSchemas(Schema ...$schemas): self
	{
		$this->oneOf->add(...$schemas);

		return $this;
	}

	public function addAnyOfSchemas(Schema ...$schemas): self
	{
		$this->anyOf->add(...$schemas);

		return $this;
	}

	public function addAllOfSchemas(Schema ...$schemas): self
	{
		$this->allOf->add(...$schemas);

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

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setNullable(bool $nullable): self
	{
		$this->nullable = $nullable;
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

<?php

declare(strict_types=1);

namespace OpenApiSchema\Components;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Example implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $description;
	protected ?string $summary;
	protected mixed $value;
	protected ?string $externalValue;

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setSummary(?string $summary): self
	{
		$this->summary = $summary;
		return $this;
	}

	public function setValue(mixed $value): self
	{
		$this->value = $value;
		return $this;
	}

	public function setExternalValue(?string $externalValue): self
	{
		$this->externalValue = $externalValue;
		return $this;
	}

}

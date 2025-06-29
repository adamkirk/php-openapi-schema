<?php

declare(strict_types=1);

namespace OpenApiSchema;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Reference implements Marshallable
{
	use ConvertsSelfToMarshallable;

	protected ?string $ref = null;
	protected ?string $summary = null;
	protected ?string $description = null;

	public function setSummary(?string $summary): self
	{
		$this->summary = $summary;
		return $this;
	}

	public function getSummary(): ?string
	{
		return $this->summary;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setRef(?string $ref): self
	{
		$this->ref = $ref;
		return $this;
	}

	public function getRef(): ?string
	{
		return $this->ref;
	}
}

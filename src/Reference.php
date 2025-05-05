<?php

declare(strict_types=1);

namespace OpenApiSchema;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Reference implements Marshallable
{
	use ConvertsSelfToMarshallable;

	protected ?string $ref;
	protected ?string $summary;
	protected ?string $description;

	public function setSummary(string $summary): self
	{
		$this->summary = $summary;
		return $this;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setRef(?string $ref): self
	{
		$this->ref = $ref;
		return $this;
	}
}

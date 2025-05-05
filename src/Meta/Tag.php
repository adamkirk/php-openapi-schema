<?php

declare(strict_types=1);

namespace OpenApiSchema\Meta;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Tag implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected string $name;
	protected ?string $description;
	protected ?ExternalDocumentation $externalDocs;

	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setExternalDocs(?ExternalDocumentation $externalDocs): self
	{
		$this->externalDocs = $externalDocs;
		return $this;
	}

}

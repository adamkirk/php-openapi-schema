<?php

declare(strict_types=1);

namespace OpenApiSchema\Meta;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class License implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected string $name;
	protected ?string $identifier;
	protected ?string $url;

	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function setIdentifier(?string $identifier): self
	{
		$this->identifier = $identifier;
		return $this;
	}

	public function setUrl(?string $url): self
	{
		$this->url = $url;
		return $this;
	}
}

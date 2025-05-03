<?php

declare(strict_types=1);

namespace OpenApiSchema\Meta;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class ExternalDocumentation implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $description;
	protected string $url;

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setUrl(string $url): self
	{
		$this->url = $url;
		return $this;
	}
}

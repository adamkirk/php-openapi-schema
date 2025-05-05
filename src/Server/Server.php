<?php

declare(strict_types=1);

namespace OpenApiSchema\Server;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Server implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected string $url;
	protected ?string $description;
	protected ServerVariables $variables;

	public function setUrl(string $url): self
	{
		$this->url = $url;
		return $this;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function addVariable(string $key, ServerVariable $variable): self
	{
		$this->variables->add($key, $variable);
		return $this;
	}
}

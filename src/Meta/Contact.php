<?php

declare(strict_types=1);

namespace OpenApiSchema\Meta;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Contact implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $name;
	protected ?string $url;
	protected ?string $email;

	public function setName(?string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function setUrl(?string $url): self
	{
		$this->url = $url;
		return $this;
	}

	public function setEmail(?string $email): self
	{
		$this->email = $email;
		return $this;
	}

}

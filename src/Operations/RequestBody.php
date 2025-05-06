<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class RequestBody implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $description;
	protected Content $content;
	protected ?bool $required;

	public function __construct()
	{
		$this->content = new Content();
	}
	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function addMediaType(string $key, MediaType $mediaType): self
	{
		$this->content->add($key, $mediaType);
		return $this;
	}

	public function setRequired(bool $required): self
	{
		$this->required = $required;
		return $this;
	}

	/** @deprecated use setRequired */
	public function isRequired(): self
	{
		$this->required = true;
		return $this;
	}

	/** @deprecated use setRequired */
	public function isNotRequired(): self
	{
		$this->required = false;
		return $this;
	}

}

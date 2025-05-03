<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Reference;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Response implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected string $description;
	protected Headers $headers;
	protected Content $content;

	public function __construct()
	{
		$this->headers = new Headers();
		$this->content = new Content();
	}

	public function addHeaders(Header|Reference ...$items): self
	{
		$this->headers->add(...$items);
		return $this;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function addMediaType(string $key, MediaType $mediaType): self
	{
		$this->content->add($key, $mediaType);
		return $this;
	}
}

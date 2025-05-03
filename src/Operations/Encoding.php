<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Reference;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Encoding implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $contentType;
	protected Headers $headers;

	// TODO make this an enum ("form","spaceDelimited","pipeDelimited","deepObject")
	protected ?string $style;

	protected ?bool $explode;

	protected bool $allowReserved = false;

	public function __construct()
	{
		$this->headers = new Headers();
	}

	public function addHeaders(Header|Reference ...$items): self
	{
		$this->headers->add(...$items);
		return $this;
	}

	public function setContentType(string $contentType): self
	{
		$this->contentType = $contentType;
		return $this;
	}

	public function setStyle(string $style): self
	{
		$this->style = $style;
		return $this;
	}

	public function shouldExplode(): self
	{
		$this->explode = true;
		return $this;
	}

	public function shouldNotExplode(): self
	{
		$this->explode = false;
		return $this;
	}

	public function shouldAllowReserved(): self
	{
		$this->allowReserved = true;
		return $this;
	}

	public function shouldNotAllowReserved(): self
	{
		$this->allowReserved = false;
		return $this;
	}
}

<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Header implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $description;
	protected bool $required = false;
	protected bool $deprecated = false;
	protected ?Schema $schema;
	protected ?Content $content;

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function isRequired(): self
	{
		$this->required = true;
		return $this;
	}

	public function isNotRequired(): self
	{
		$this->required = false;
		return $this;
	}

	public function isDeprecated(): self
	{
		$this->deprecated = true;
		return $this;
	}

	public function isNotDeprecated(): self
	{
		$this->deprecated = false;
		return $this;
	}

	public function setSchema(Schema $schema): self
	{
		$this->schema = $schema;
		return $this;
	}

	public function setContent(Content $content): self
	{
		$this->content = $content;
		return $this;
	}

}

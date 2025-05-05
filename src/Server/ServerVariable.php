<?php

declare(strict_types=1);

namespace OpenApiSchema\Server;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class ServerVariable implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	/** @var string[] $enum */
	protected array $enum;
	protected string $default;
	protected ?string $description;

	/**
	 * @param string[] $enum
	 */
	public function setEnum(array $enum): self
	{
		$this->enum = $enum;
		return $this;
	}

	public function setDefault(string $default): self
	{
		$this->default = $default;
		return $this;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

}

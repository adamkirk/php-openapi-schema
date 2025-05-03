<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class MediaType implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected Schema $schema;

	protected Encoding $encoding;

	public function setSchema(Schema $schema): self
	{
		$this->schema = $schema;
		return $this;
	}

	public function setEncoding(Encoding $encoding): self
	{
		$this->encoding = $encoding;
		return $this;
	}
}

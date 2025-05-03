<?php

declare(strict_types=1);

namespace OpenApiSchema\Components;

use OpenApiSchema\Server\Server;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\StringDictionary;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Link implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $description;
	protected ?string $operationRef;
	protected ?string $operationId;
	protected mixed $requestBody;
	protected Server $body;
	protected StringDictionary $parameters;

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setOperationRef(?string $operationRef): self
	{
		$this->operationRef = $operationRef;
		return $this;
	}

	public function setOperationId(?string $operationId): self
	{
		$this->operationId = $operationId;
		return $this;
	}

	public function setRequestBody(mixed $requestBody): self
	{
		$this->requestBody = $requestBody;
		return $this;
	}

	public function setServer(Server $server): self
	{
		$this->body = $server;
		return $this;
	}

	public function addParameter(string $key, string $value): self
	{
		$this->parameters->add($key, $value);
		return $this;
	}

}

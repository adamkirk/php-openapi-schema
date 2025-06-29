<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Reference;
use OpenApiSchema\Server\Server;
use OpenApiSchema\Server\Servers;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Meta\ExternalDocumentation;
use OpenApiSchema\Security\SecurityRequirements;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Operation implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	/** @var string[] $tags */
	protected array $tags;
	protected ?string $summary;
	protected ?string $description;
	protected ?ExternalDocumentation $externalDocs;
	protected ?string $operationId;
	protected Parameters $parameters;
	protected ?RequestBody $requestBody;
	protected Security $security;
	protected Responses $responses;
	protected Servers $servers;
	protected ?bool $deprecated;

	// Need to deal with this one still...
	protected PathItems $callbacks;

	public function __construct()
	{
		$this->servers = new Servers();
		$this->tags = [];
		$this->parameters = new Parameters();
		$this->responses = new Responses();
		$this->callbacks = new PathItems();
		$this->security = new Security();
	}

	public function addTag(string $tag): self
	{
		$this->tags[] = $tag;
		return $this;
	}

	public function setSummary(?string $summary): self
	{
		$this->summary = $summary;
		return $this;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setExternalDocs(?ExternalDocumentation $externalDocs): self
	{
		$this->externalDocs = $externalDocs;
		return $this;
	}

	public function setOperationId(?string $operationId): self
	{
		$this->operationId = $operationId;
		return $this;
	}

	public function addParameters(Parameter ...$parameters): self
	{
		$this->parameters->add(...$parameters);
		return $this;
	}

	public function setRequestBody(?RequestBody $requestBody): self
	{
		$this->requestBody = $requestBody;
		return $this;
	}

	public function addResponse(string $key, Response|Reference $response): self
	{
		$this->responses->add($key, $response);
		return $this;
	}

	public function addCallback(string $key, PathItem $pathItem): self
	{
		$this->callbacks->add($key, $pathItem);
		return $this;
	}

	public function setDeprecated(?bool $deprecated): self
	{
		$this->deprecated = $deprecated;
		return $this;
	}

	public function addSecurityRequirement(SecurityRequirements $requirement): self
	{
		$this->security->add($requirement);
		return $this;
	}

	public function addServers(Server ...$servers): self
	{
		$this->servers->add(...$servers);
		return $this;
	}
}

<?php

declare(strict_types=1);

namespace OpenApiSchema\Components;

use OpenApiSchema\Reference;
use OpenApiSchema\Operations\Header;
use OpenApiSchema\Operations\Schema;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Operations\Headers;
use OpenApiSchema\Operations\Schemas;
use OpenApiSchema\Operations\PathItem;
use OpenApiSchema\Operations\Response;
use OpenApiSchema\Operations\Parameter;
use OpenApiSchema\Operations\PathItems;
use OpenApiSchema\Operations\Responses;
use OpenApiSchema\Operations\Parameters;
use OpenApiSchema\Operations\RequestBody;
use OpenApiSchema\Security\SecurityScheme;
use OpenApiSchema\Operations\RequestBodies;
use OpenApiSchema\Security\SecuritySchemes;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Components implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected Responses $responses;
	protected Parameters $parameters;
	protected Schemas $schemas;
	protected Headers $headers;
	protected RequestBodies $requestBodies;
	protected PathItems $pathItems;
	protected Examples $examples;
	protected Links $links;
	protected SecuritySchemes $securitySchemes;
	protected PathItems|Reference|null $callbacks;

	public function __construct()
	{

		$this->parameters = new Parameters();
		$this->responses = new Responses();
		$this->schemas = new Schemas();
		$this->headers = new Headers();
		$this->requestBodies = new RequestBodies();
		$this->pathItems = new PathItems();
		$this->examples = new Examples();
		$this->links = new Links();
		$this->securitySchemes = new SecuritySchemes();
	}

	public function addResponse(string $key, Response|Reference $response): self
	{
		$this->responses->add($key, $response);
		return $this;
	}


	public function addParameter(Parameter|Reference $param): self
	{
		$this->parameters->add($param);
		return $this;
	}

	public function addSchema(string $key, Schema $schema): self
	{
		$this->schemas->add($key, $schema);
		return $this;
	}

	public function addHeader(Header|Reference $header): self
	{
		$this->headers->add($header);
		return $this;
	}

	public function addRequestBody(string $key, RequestBody|Reference $requestBody): self
	{
		$this->requestBodies->add($key, $requestBody);
		return $this;
	}


	public function addPathItem(string $key, PathItem $pathItem): self
	{
		$this->pathItems->add($key, $pathItem);
		return $this;
	}

	public function addExample(string $key, Example|Reference $example): self
	{
		$this->examples->add($key, $example);
		return $this;
	}

	public function addLink(string $key, Link|Reference $link): self
	{
		$this->links->add($key, $link);
		return $this;
	}

	public function addSecurityScheme(string $key, SecurityScheme|Reference $scheme): self
	{
		$this->securitySchemes->add($key, $scheme);
		return $this;
	}
}

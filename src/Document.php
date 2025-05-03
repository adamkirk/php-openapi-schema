<?php

declare(strict_types=1);

namespace OpenApiSchema;

use RuntimeException;
use OpenApiSchema\Meta\Tag;
use OpenApiSchema\Meta\Info;
use OpenApiSchema\Meta\Tags;
use OpenApiSchema\Server\Server;
use OpenApiSchema\Server\Servers;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Operations\PathItem;
use OpenApiSchema\Operations\PathItems;
use OpenApiSchema\Components\Components;
use OpenApiSchema\Spec\MarshallingContext;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Meta\ExternalDocumentation;
use OpenApiSchema\Security\SecurityRequirement;
use OpenApiSchema\Security\SecurityRequirements;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Document implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $openapi;
	protected Info $info;
	protected ?string $jsonSchemaDialect;
	protected Servers $servers;
	protected PathItems $paths;
	protected Components $components;
	protected PathItems $webhooks;
	protected SecurityRequirements $security;
	protected Tags $tags;
	protected ?ExternalDocumentation $externalDocs;

	public function __construct()
	{
		$this->servers = new Servers();
		$this->paths = new PathItems();
		$this->tags = new Tags();
		$this->components = new Components();
		$this->webhooks = new PathItems();
		$this->security = new SecurityRequirements();
	}

	public function setOpenapi(string $openapi): self
	{
		$this->openapi = $openapi;
		return $this;
	}

	public function setInfo(Info $info): self
	{
		$this->info = $info;
		return $this;
	}

	public function setJsonSchemaDialect(?string $jsonSchemaDialect): self
	{
		$this->jsonSchemaDialect = $jsonSchemaDialect;
		return $this;
	}

	public function addServers(Server ...$servers): self
	{
		$this->servers->add(...$servers);
		return $this;
	}

	public function addPathItem(string $path, PathItem $item): self
	{
		$this->paths->add($path, $item);
		return $this;
	}

	public function setComponents(Components $components): self
	{
		$this->components = $components;
		return $this;
	}

	public function addWebhook(string $key, PathItem $pathItem): self
	{
		$this->webhooks->add($key, $pathItem);
		return $this;
	}

	public function addSecurityRequirement(string $key, SecurityRequirement $requirement): self
	{
		$this->security->add($key, $requirement);
		return $this;
	}

	public function addTags(Tag ...$tags): self
	{
		$this->tags->add(...$tags);
		return $this;
	}

	public function setExternalDocs(?ExternalDocumentation $externalDocs): self
	{
		$this->externalDocs = $externalDocs;
		return $this;
	}

	public function toJson(MarshallingContext $ctx): string
	{
		if ($this->openapi !== null) {
			$ctx->setIfNotExists('openApiVersion', $this->openapi);
		}

		$asArray = $this->toMarshallable($ctx);

		$data = json_encode($asArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

		if ($data === false) {
			throw new RuntimeException("Error encoding json: " . json_last_error_msg());
		}

		return $data;
	}

	protected function omitEmptyDictionaries(): bool
	{
		return true;
	}

	// TODO: move this to a validator class
	// public function validate(): void
	// {
	// 	// Create a new validator
	// 	$validator = new Validator();

	// 	// Register our schema
	// 	$validator->resolver()->registerFile(
	// 		'openapi',
	// 		__DIR__ . '/schemas/3.1.json',
	// 	);

	// 	$data = $this->toJson();

	// 	// Decode $data
	// 	$data = json_decode($data);

	// 	/** @var ValidationResult $result */
	// 	$result = $validator->validate($data,file_get_contents( __DIR__ . '/schemas/3.1.json'));

	// 	if ($result->isValid()) {
	// 		echo "Valid", PHP_EOL;
	// 	} else {
	// 		// Print errors
	// 		print_r((new ErrorFormatter())->format($result->error()));
	// 	}
	// }
}

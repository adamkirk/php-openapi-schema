<?php

declare(strict_types=1);

namespace OpenApiSchema\Operations;

use OpenApiSchema\Reference;
use OpenApiSchema\Server\Server;
use OpenApiSchema\Server\Servers;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class PathItem implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $ref;
	protected ?string $summary;
	protected ?string $description;
	protected Servers $servers;
	protected Parameters $parameters;
	protected ?Operation $get;
	protected ?Operation $put;
	protected ?Operation $post;
	protected ?Operation $delete;
	protected ?Operation $options;
	protected ?Operation $head;
	protected ?Operation $patch;
	protected ?Operation $trace;

	public function __construct()
	{
		$this->servers = new Servers();
		$this->parameters = new Parameters();
	}

	public function setRef(?string $ref): self
	{
		$this->ref = $ref;
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

	public function addServer(Server ...$servers): self
	{
		$this->servers->add(...$servers);
		return $this;
	}

	public function addParameters(Parameter|Reference ...$parameters): self
	{
		$this->parameters->add(...$parameters);
		return $this;
	}

	public function setGet(?Operation $get): self
	{
		$this->get = $get;
		return $this;
	}

	public function setPut(?Operation $put): self
	{
		$this->put = $put;
		return $this;
	}

	public function setPost(?Operation $post): self
	{
		$this->post = $post;
		return $this;
	}

	public function setDelete(?Operation $delete): self
	{
		$this->delete = $delete;
		return $this;
	}

	public function setOptions(?Operation $options): self
	{
		$this->options = $options;
		return $this;
	}

	public function setHead(?Operation $head): self
	{
		$this->head = $head;
		return $this;
	}

	public function setPatch(?Operation $patch): self
	{
		$this->patch = $patch;
		return $this;
	}

	public function setTrace(?Operation $trace): self
	{
		$this->trace = $trace;
		return $this;
	}

}

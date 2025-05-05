<?php

declare(strict_types=1);

namespace OpenApiSchema\Security;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class SecurityScheme implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $description;
	protected ?string $type;
	protected ?string $name;
	//TODO: enum (query,header,cookie)
	protected ?string $in;
	protected ?string $scheme;
	protected ?string $bearerFormat;
	protected ?string $openIdConnectUrl;
	protected OAuthFlows $flows;


	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setType(?string $type): self
	{
		$this->type = $type;
		return $this;
	}


	public function setName(?string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function setIn(?string $in): self
	{
		$this->in = $in;
		return $this;
	}

	public function setScheme(?string $scheme): self
	{
		$this->scheme = $scheme;
		return $this;
	}

	public function setBearerFormat(?string $bearerFormat): self
	{
		$this->bearerFormat = $bearerFormat;
		return $this;
	}

	public function setOpenIdConnectUrl(?string $openIdConnectUrl): self
	{
		$this->openIdConnectUrl = $openIdConnectUrl;
		return $this;
	}

	public function setOAuthFlows(OAuthFlows $flows): self
	{
		$this->flows = $flows;
		return $this;
	}
}

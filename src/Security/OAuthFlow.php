<?php

declare(strict_types=1);

namespace OpenApiSchema\Security;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\StringDictionary;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class OAuthFlow implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?string $authorizationUrl;
	protected ?string $tokenUrl;
	protected ?string $refreshUrl;
	protected StringDictionary $scopes;

	public function __construct()
	{
		$this->scopes = new StringDictionary();
	}

	public function setAuthorizationUrl(string $authorizationUrl): self
	{
		$this->authorizationUrl = $authorizationUrl;
		return $this;
	}

	public function setTokenUrl(string $tokenUrl): self
	{
		$this->tokenUrl = $tokenUrl;
		return $this;
	}

	public function setRefreshUrl(string $refreshUrl): self
	{
		$this->refreshUrl = $refreshUrl;
		return $this;
	}

	public function addScope(string $key, string $value): self
	{
		$this->scopes->add($key, $value);
		return $this;
	}
}

<?php

declare(strict_types=1);

namespace OpenApiSchema\Security;

use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class OAuthFlows implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected ?OAuthFlow $implicit;
	protected ?OAuthFlow $password;
	protected ?OAuthFlow $clientCredentials;
	protected ?OAuthFlow $authorizationCode;

	public function setImplicit(OAuthFlow $oAuthFlow): self
	{
		$this->implicit = $oAuthFlow;
		return $this;
	}

	public function setPassword(OAuthFlow $oAuthFlow): self
	{
		$this->password = $oAuthFlow;
		return $this;
	}

	public function setClientCredentials(OAuthFlow $oAuthFlow): self
	{
		$this->clientCredentials = $oAuthFlow;
		return $this;
	}

	public function setAuthorizationCode(OAuthFlow $oAuthFlow): self
	{
		$this->authorizationCode = $oAuthFlow;
		return $this;
	}
}

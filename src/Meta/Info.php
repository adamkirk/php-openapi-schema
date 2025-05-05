<?php

declare(strict_types=1);

namespace OpenApiSchema\Meta;

use OpenApiSchema\Spec\HasCustomAttributes;
use OpenApiSchema\Spec\Marshallable;
use OpenApiSchema\Spec\ConvertsSelfToMarshallable;

class Info implements Marshallable
{
	use ConvertsSelfToMarshallable;
	use HasCustomAttributes;

	protected string $title;
	protected ?string $summary;
	protected ?string $description;
	protected ?string $termsOfService;
	protected ?Contact $contact;
	protected ?License $license;
	protected string $version;

	public function setTitle(string $title): self
	{
		$this->title = $title;
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

	public function setTermsOfService(?string $termsOfService): self
	{
		$this->termsOfService = $termsOfService;
		return $this;
	}

	public function setContact(?Contact $contact): self
	{
		$this->contact = $contact;
		return $this;
	}

	public function setLicense(?License $license): self
	{
		$this->license = $license;
		return $this;
	}

	public function setVersion(string $version): self
	{
		$this->version = $version;
		return $this;
	}
}

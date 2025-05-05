<?php

declare(strict_types=1);

namespace Tests\Feature;

use OpenApiSchema\Document;
use OpenApiSchema\Meta\Info;
use PHPUnit\Framework\TestCase;
use OpenApiSchema\Server\Server;
use OpenApiSchema\Operations\Schema;
use OpenApiSchema\Operations\PathItem;
use OpenApiSchema\Operations\Response;
use OpenApiSchema\Operations\MediaType;
use OpenApiSchema\Operations\Operation;
use OpenApiSchema\Operations\Parameter;
use OpenApiSchema\Spec\MarshallingContext;
use OpenApiSchema\Operations\RequestBody;

/**
 * @covers Document
 */
class VeryBasicTest extends TestCase
{
	/**
	 * Builds the petstore spec, and compares the resulting JSON with example file.
	 *
	 * This covers a good chunk of the code.
	 */
	public function test_basic(): void
	{
		$doc = new Document();
		$doc->setOpenapi('3.1.0')
			->setInfo(
				(new Info())
					->setTitle("Example API")
					->setDescription("An example API using the OpenApiSchema components")
					->setVersion("1.0.0")
					->setSummary("A very basic API"),
			)
			->addServers(
				(new Server())->setUrl("/api/v1"),
			)
			->addPathItem(
				"/v1/resource/{id}",
				(new PathItem())
					->setPut(
						(new Operation())
							->setSummary("Update a resource")
							->setDescription("Update a resource by Id.")
							->addParameters(
								(new Parameter())
									->setName("id")
									->isRequired()
									->setIn("path")
									->setSchema(
										(new Schema())->setType("integer"),
									),
							)
							->addResponse(
								"200",
								(new Response())
									->setDescription("Successful operation")
									->addMediaType(
										"application/json",
										(new MediaType())
											->setSchema(
												(new Schema())
													->addProperty(
														"id",
														(new Schema())->setType("integer"),
													)
													->addProperty(
														"name",
														(new Schema())->setType("string"),
													),
											),
									),
							)
							->addResponse("404", (new Response())->setDescription("resource not found"))
							->setRequestBody(
								(new RequestBody())
									->isRequired()
									->setDescription("Resource data structure")
									->addMediaType(
										"application/json",
										(new MediaType())
											->setSchema(
												(new Schema())
													->addProperty(
														"name",
														(new Schema())->setType("string"),
													),
											),
									),
							),
					),
			);

		$this->assertJsonStringEqualsJsonFile(
			__DIR__ . '/examples/very_basic.json',
			$doc->toJson(new MarshallingContext()),
		);
	}
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use OpenApiSchema as OA;

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
		$doc = new OA\Document();
		$doc->setOpenapi('3.1.0')
			->setInfo(
				(new OA\Meta\Info())
					->setTitle("Example API")
					->setDescription("An example API using the OpenApiSchema components")
					->setVersion("1.0.0")
					->setSummary("A very basic API"),
			)
			->addServers(
				(new OA\Server\Server())->setUrl("/api/v1"),
			)
			->addPathItem(
				"/v1/resource/{id}",
				(new OA\Operations\PathItem())
					->setPut(
						(new OA\Operations\Operation())
							->setSummary("Update a resource")
							->setDescription("Update a resource by Id.")
							->addParameters(
								(new OA\Operations\Parameter())
									->setName("id")
									->isRequired()
									->setIn("path")
									->setSchema(
										(new OA\Operations\Schema())->setType("integer"),
									),
							)
							->addResponse(
								"200",
								(new OA\Operations\Response())
									->setDescription("Successful operation")
									->addMediaType(
										"application/json",
										(new OA\Operations\MediaType())
											->setSchema(
												(new OA\Operations\Schema())
													->addProperty(
														"id",
														(new OA\Operations\Schema())->setType("integer"),
													)
													->addProperty(
														"name",
														(new OA\Operations\Schema())->setType("string"),
													),
											),
									),
							)
							->addResponse("404", (new OA\Operations\Response())->setDescription("resource not found"))
							->setRequestBody(
								(new OA\Operations\RequestBody())
									->isRequired()
									->setDescription("Resource data structure")
									->addMediaType(
										"application/json",
										(new OA\Operations\MediaType())
											->setSchema(
												(new OA\Operations\Schema())
													->addProperty(
														"name",
														(new OA\Operations\Schema())->setType("string"),
													),
											),
									),
							),
					),
			);

		$this->assertJsonStringEqualsJsonFile(
			__DIR__ . '/examples/very_basic.json',
			$doc->toJson(new OA\Spec\MarshallingContext()),
		);
	}

	public function test_user_guide(): void
	{
		# Step 1
		$doc = (new OA\Document())->setOpenapi("3.1.0"); //JSON path `.openapi`

		# Step 2
		$doc->setInfo(
			(new OA\Meta\Info())
				->setVersion("1.0.0") // JSON path `.info.version`
				->setTitle("My API") // JSON path `.info.title`
				->setDescription("An API that does things"), // JSON path `.info.description`
		);

		# Step 3
		$doc->addPathItem(
			"/api/v1/users",
			(new OA\Operations\PathItem()) // JSON path `.paths[/api/v1/users]`
				->setGet(
					(new OA\Operations\Operation()) // JSON path `.paths[/api/v1/users].get`
						->setSummary("list users") // JSON path `.paths[/api/v1/users].get.summary`
						->addParameters(
							(new OA\Operations\Parameter()) // JSON path `.paths[/api/v1/users].get.parameters[0]`
								->setIn("query") // JSON path `.paths[/api/v1/users].get.parameters[0].in`
								->setName("page") // JSON path `.paths[/api/v1/users].get.parameters[0].name`
								->setSchema( // JSON path `.paths[/api/v1/users].get.parameters[0].schema`
									(new OA\Operations\Schema())->setType("integer"), // JSON path `.paths[/api/v1/users].get.parameters[0].schema.type`
								),
							(new OA\Operations\Parameter()) // JSON path `.paths[/api/v1/users].get.parameters[1]`
								->setIn("query")  // JSON path `.paths[/api/v1/users].get.parameters[1].in`
								->setName("page_size") // JSON path `.paths[/api/v1/users].get.parameters[1].name`
								->setSchema(  // JSON path `.paths[/api/v1/users].get.parameters[1].schema`
									(new OA\Operations\Schema())->setType("integer"),  // JSON path `.paths[/api/v1/users].get.parameters[1].schema.type`
								),
						)
						->addResponse(
							"400", // JSON path `.paths[/api/v1/users].get.responses[400]`
							(new OA\Operations\Response()) // JSON path `.paths[/api/v1/users].get.responses[400]`
								->setDescription("One of the query parameters was invalid"), // JSON path `.paths[/api/v1/users].get.responses[400].description`
						)
						->addResponse(
							"200", // JSON path `.paths[/api/v1/users].get.responses[200]`
							(new OA\Operations\Response())
								->setDescription("A list of users") // JSON path `.paths[/api/v1/users].get.responses[200].description`
								->addMediaType(
									"application/json", // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json]`
									(new OA\Operations\MediaType())
										->setSchema( // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema`
											(new OA\Operations\Schema())
												->setItems( // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items`
													(new OA\Operations\Schema())
														->addProperty(
															"id", // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.id`
															(new OA\Operations\Schema())
																->setType("integer"), // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.id.type`
														)
														->addProperty(
															"name", // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.name`
															(new OA\Operations\Schema())
																->setType("string"), // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.name.type`
														)
														->addProperty(
															"email",  // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.email`
															(new OA\Operations\Schema())
																->setType("string"),  // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.email.type`
														),
												),
										),
								),
						),
				),
		);

		# Step 4
		$doc->setComponents( // JSON path `.components`
			(new OA\Components\Components())
				->addSchema(
					"user",  // JSON path `.components.schemas.user`
					(new OA\Operations\Schema())
						->addProperty(
							"id",  // JSON path `.components.schemas.user.properties.id`
							(new OA\Operations\Schema())
								->setType("integer") // JSON path `.components.schemas.user.properties.id.type`
								->setExclusiveMinimum(0), // JSON path `.components.schemas.user.properties.id.exclusiveMinimum`
						)
						->addProperty(
							"name", // JSON path `.components.schemas.user.properties.name`
							(new OA\Operations\Schema())
								->setType("string"), // JSON path `.components.schemas.user.properties.name.type`
						)
						->addProperty(
							"email", // JSON path `.components.schemas.user.properties.email`
							(new OA\Operations\Schema())
								->setType("string"), // JSON path `.components.schemas.user.properties.email.type`
						),
				),
		);

		# Step 5
		$doc->addPathItem(
			"/api/v1/users/{id}", // JSON path `.paths[/api/v1/users/{id}]`
			(new OA\Operations\PathItem())
				->addParameters(
					(new OA\Operations\Parameter()) // JSON path `.paths[/api/v1/users/{id}].parameters[0]`
						->setName("id") // JSON path `.paths[/api/v1/users/{id}].parameters[0].name`
						->setIn("path") // JSON path `.paths[/api/v1/users/{id}].parameters[0].in`
						->isRequired() // JSON path `.paths[/api/v1/users/{id}].parameters[0].required`
						->setSchema(
							(new OA\Operations\Schema()) // JSON path `.paths[/api/v1/users/{id}].parameters[0].schema`
								->setType("integer"), // JSON path `.paths[/api/v1/users/{id}].parameters[0].schema.type`
						),
				)
				->setGet(
					(new OA\Operations\Operation()) // JSON path `.paths[/api/v1/users/{id}].get`
						->setDescription("Get a user") // JSON path `.paths[/api/v1/users/{id}].get.description`
						->addResponse(
							"200", // JSON path `.paths[/api/v1/users/{id}].get.responses[200]`
							(new OA\Operations\Response())
								->setDescription("The user.") // JSON path `.paths[/api/v1/users/{id}].get.responses[200].description`
								->addMediaType(
									"application/json",  // JSON path `.paths[/api/v1/users/{id}].get.responses[200].content[application/json]`
									(new OA\Operations\MediaType())
										->setSchema(
											(new OA\Operations\Schema()) // JSON path `.paths[/api/v1/users/{id}].get.responses[200].content[application/json].schema`
												->setRef("#/components/schemas/user"), // JSON path `.paths[/api/v1/users/{id}].get.responses[200].content[application/json].schema.$ref`
										),
								),
						),
				)
				->setPut(
					(new OA\Operations\Operation()) // JSON path `.paths[/api/v1/users/{id}].put`
						->setDescription("Get a user") // JSON path `.paths[/api/v1/users/{id}].put.description`
						->setRequestBody(
							(new OA\Operations\RequestBody()) // JSON path `.paths[/api/v1/users/{id}].put.requestBody`
								->addMediaType(
									"application/json", // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json]`
									(new OA\Operations\MediaType())
										->setSchema(
											(new OA\Operations\Schema())  // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema`
												->addProperty(
													"name",  // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.name`
													(new OA\Operations\Schema())
														->setType("string"), // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.name.type`
												)
												->addProperty(
													"email", // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.email`
													(new OA\Operations\Schema())
														->setType("string"), // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.email.type`
												),
										),
								),
						)
						->addResponse(
							"200", // JSON path `.paths[/api/v1/users/{id}].put.responses[200]`
							(new OA\Operations\Response())
								->setDescription("The user.") // JSON path `.paths[/api/v1/users/{id}].put.responses[200].description`
								->addMediaType(
									"application/json",  // JSON path `.paths[/api/v1/users/{id}].put.responses[200].content[application/json]`
									(new OA\Operations\MediaType())
										->setSchema(
											(new OA\Operations\Schema()) // JSON path `.paths[/api/v1/users/{id}].put.responses[200].content[application/json].schema`
												->setRef("#/components/schemas/user"), // JSON path `.paths[/api/v1/users/{id}].put.responses[200].content[application/json].schema.$ref`
										),
								),
						),
				)
				->setDelete(
					(new OA\Operations\Operation()) // JSON path `.paths[/api/v1/users/{id}].delete`
						->setDescription("Delete a user") // JSON path `.paths[/api/v1/users/{id}].delete.description`
						->addResponse(
							"204", // JSON path `.paths[/api/v1/users/{id}].delete.responses[204]`
							(new OA\Operations\Response())
								->setDescription("user successfully deleted (no content)"), // JSON path `.paths[/api/v1/users/{id}].delete.responses[204].description`
						),
				),
		);

		$jsonSpec = $doc->toJson(new OA\Spec\MarshallingContext());
		$this->assertJsonStringEqualsJsonFile(
			__DIR__ . '/examples/user_guide.json',
			$doc->toJson(new OA\Spec\MarshallingContext()),
		);
	}
}

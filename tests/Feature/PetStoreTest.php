<?php

declare(strict_types=1);

namespace Tests\Feature;

use OpenApiSchema\Document;
use OpenApiSchema\Meta\Tag;
use OpenApiSchema\Meta\Info;
use OpenApiSchema\Meta\Contact;
use OpenApiSchema\Meta\License;
use PHPUnit\Framework\TestCase;
use OpenApiSchema\Server\Server;
use OpenApiSchema\Operations\Schema;
use OpenApiSchema\Security\OAuthFlow;
use OpenApiSchema\Operations\PathItem;
use OpenApiSchema\Operations\Response;
use OpenApiSchema\Security\OAuthFlows;
use OpenApiSchema\Operations\MediaType;
use OpenApiSchema\Operations\Operation;
use OpenApiSchema\Operations\Parameter;
use OpenApiSchema\Components\Components;
use OpenApiSchema\Spec\MarshallingContext;
use OpenApiSchema\Operations\RequestBody;
use OpenApiSchema\Security\SecurityScheme;
use OpenApiSchema\Meta\ExternalDocumentation;
use OpenApiSchema\Security\SecurityRequirement;
use OpenApiSchema\Security\SecurityRequirements;

/**
 * @covers Document
 */
class PetStoreTest extends TestCase
{
	/**
	 * Builds the petstore spec, and compares the resulting JSON with example file.
	 *
	 * This covers a good chunk of the code.
	 */
	public function test_petstore(): void
	{
		$doc = new Document();
		$doc->setOpenapi('3.1.0')
			->setInfo(
				(new Info())
					->setTitle("Swagger Petstore - OpenAPI 3.1")
					->setDescription("This is a sample Pet Store Server based on the OpenAPI 3.1 specification.\nYou can find out more about\nSwagger at [https://swagger.io](https://swagger.io).")
					->setTermsOfService("https://swagger.io/terms/")
					->setLicense(
						(new License())
							->setName("Apache 2.0")
							->setUrl("https://www.apache.org/licenses/LICENSE-2.0.html"),
					)
					->setContact(
						(new Contact())
							->setEmail("apiteam@swagger.io"),
					)
					->setVersion("1.0.9")
					->setSummary("Pet Store 3.1")
					->addCustomAttribute("x-namespace", "swagger"),
			)
			->setExternalDocs(
				(new ExternalDocumentation())
					->setDescription("Find out more about Swagger")
					->setUrl("https://swagger.io"),
			)
			->addServers(
				(new Server())->setUrl("/api/v31"),
			)
			->addTags(
				(new Tag())->setName("pet")
					->setDescription("Everything about your Pets")
					->setExternalDocs(
						(new ExternalDocumentation())
							->setDescription("Find out more")
							->setUrl("https://swagger.io"),
					),
			);
		$petsPathItem = new PathItem();
		$petsPathItem->setPut(
			(new Operation())
				->addTag("pet")
				->setSummary("Update an existing pet.")
				->setDescription("Update an existing pet by Id.")
				->setOperationId("updatePet")
				->addSecurityRequirement(
					(new SecurityRequirements())
						->add(
							"petstore_auth",
							(new SecurityRequirement())->add("write:pets", "read:pets"),
						),
				)
				->addResponse(
					"200",
					(new Response())
						->setDescription("Successful operation")
						->addMediaType(
							"application/xml",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in XML Format")
										->isReadOnly(),
								),
						)
						->addMediaType(
							"application/json",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in JSON Format")
										->isReadOnly(),
								),
						),
				)
				->addResponse("400", (new Response())->setDescription("Invalid ID supplied"))
				->addResponse("404", (new Response())->setDescription("Pet not found"))
				->addResponse("405", (new Response())->setDescription("Validation exception"))
				->addResponse("default", (new Response())->setDescription("Unexpected error"))
				->setRequestBody(
					(new RequestBody())
						->isRequired()
						->setDescription("Pet object that needs to be updated in the store")
						->addMediaType(
							"application/json",
							(new MediaType())
								->setSchema(
									(new Schema())
										->markFieldsAsRequired("id")
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in JSON Format")
										->isWriteOnly(),
								),
						)
						->addMediaType(
							"application/xml",
							(new MediaType())
							->setSchema(
								(new Schema())
									->markFieldsAsRequired("id")
									->setRef("#/components/schemas/Pet")
									->setDescription("A Pet in XML Format")
									->isWriteOnly(),
							),
						),
				),
		);

		$petsPathItem->setPost(
			(new Operation())
				->addTag("pet")
				->setSummary("Add a new pet to the store.")
				->setDescription("Add a new pet to the store.")
				->setOperationId("addPet")
				->addSecurityRequirement(
					(new SecurityRequirements())
						->add(
							"petstore_auth",
							(new SecurityRequirement())->add("write:pets", "read:pets"),
						),
				)
				->setRequestBody(
					(new RequestBody())
						->isRequired()
						->setDescription("Create a new pet in the store")
						->addMediaType(
							"application/json",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in JSON Format")
										->markFieldsAsRequired("id")
										->isWriteOnly(),
								),
						)
						->addMediaType(
							"application/xml",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in XML Format")
										->markFieldsAsRequired("id")
										->isWriteOnly(),
								),
						),
				)
				->addResponse("405", (new Response())->setDescription("Invalid input"))
				->addResponse("default", (new Response())->setDescription("Unexpected error"))
				->addResponse(
					"200",
					(new Response())
						->setDescription("Successful operation")
						->addMediaType(
							"application/xml",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in XML Format")
										->isReadOnly(),
								),
						)
						->addMediaType(
							"application/json",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in JSON format")
										->isReadOnly(),
								),
						),
				),
		);

		$doc->addPathItem("/pet", $petsPathItem);

		$petsWithIdPathItem = new PathItem();
		$petsWithIdPathItem->setGet(
			(new Operation())
				->addTag("pet")
				->setSummary("Find pet by it's identifier.")
				->setDescription("Returns a pet when 0 < ID <= 10.  ID > 10 or non-integers will simulate API error conditions.")
				->setOperationId("getPetById")
				->addSecurityRequirement(
					(new SecurityRequirements())
						->add(
							"petstore_auth",
							(new SecurityRequirement())->add("write:pets", "read:pets"),
						),
				)
				->addSecurityRequirement(
					(new SecurityRequirements())
						->add(
							"api_key",
							(new SecurityRequirement())->add(),
						),
				)
				->addParameters(
					(new Parameter())
						->setName("petId")
						->setIn("path")
						->setDescription("ID of pet that needs to be fetched")
						->isRequired()
						->setSchema(
							(new Schema())
								->setType("integer")
								->setFormat("int64")
								->setDescription("param ID of pet that needs to be fetched")
								->setExclusiveMaximum(10)
								->setExclusiveMinimum(1),
						),
				)
				->addResponse("400", (new Response())->setDescription("Invalid ID supplied"))
				->addResponse("404", (new Response())->setDescription("Pet not found"))
				->addResponse("default", (new Response())->setDescription("Unexpected error"))
				->addResponse(
					"200",
					(new Response())
						->setDescription("The pet")
						->addMediaType(
							"application/json",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in JSON format"),
								),
						)
						->addMediaType(
							"application/xml",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setRef("#/components/schemas/Pet")
										->setDescription("A Pet in XML format"),
								),
						),
				),
		);

		$doc->addPathItem("/pet/{petId}", $petsWithIdPathItem);


		$webhookPathItem = new PathItem();
		$webhookPathItem->setPost(
			(new Operation())
				->setRequestBody(
					(new RequestBody())
						->setDescription("Information about a new pet in the system")
						->addMediaType(
							"application/json",
							(new MediaType())
								->setSchema(
									(new Schema())
										->setDescription("Webhook Pet")
										->setRef("#/components/schemas/Pet"),
								),
						),
				)
				->addResponse(
					"200",
					(new Response())
						->setDescription("Return a 200 status to indicate that the data was received successfully"),
				),
		);

		$doc->addWebhook("newPet", $webhookPathItem);

		$doc->setComponents(
			(new Components())
				->addSchema(
					"Category",
					(new Schema())
						->setDescription("Category")
						->addProperty(
							'id',
							(new Schema())
								->setType("integer")
								->setFormat("int64"),
						)
						->addProperty(
							'name',
							(new Schema())
								->setType("string"),
						)
						->addCustomAttribute(
							'xml',
							[
								"name" => "Category",
							],
						)
						->addCustomAttribute('$id', '/api/v31/components/schemas/category'),
				)
				->addSchema(
					"Pet",
					(new Schema())
						->setDescription("Pet")
						->addCustomAttribute('$schema', 'https://json-schema.org/draft/2020-12/schema')
						->addProperty(
							"id",
							(new Schema())
								->setType("integer")
								->setFormat("int64"),
						)
						->addProperty(
							"category",
							(new Schema())
								->setRef("#/components/schemas/Category")
								->setDescription("Pet Category"),
						)
						->addProperty(
							"name",
							(new Schema())
								->setType('string')
								->setExamples(["doggie"]),
						)
						->addProperty(
							"photoUrls",
							(new Schema())
								->setType('array')
								->setItems(
									(new Schema())
										->setType("string")
										->addCustomAttribute("xml", [
											"name" => "photoUrl",
										]),
								)
								->addCustomAttribute("xml", [
									"wrapped" => true,
								]),
						)
						->addProperty(
							"tags",
							(new Schema())
								->setType('array')
								->setItems(
									(new Schema())
										->setRef('#/components/schemas/Tag'),
								)
								->addCustomAttribute("xml", [
									"wrapped" => true,
								]),
						)
						->addProperty(
							"status",
							(new Schema())
								->setType('string')
								->setDescription("pet status in the store")
								->addEnumCases("available", "pending", "sold"),
						)
						->addProperty(
							"availableInstances",
							(new Schema())
								->setType('integer')
								->setFormat('int32')
								->setExclusiveMaximum(10)
								->setExclusiveMinimum(1)
								->setExamples(["7"])
								->addCustomAttribute("swagger-extension", true),
						)
						->addProperty(
							"petDetailsId",
							(new Schema())
								->setType('integer')
								->setFormat('int64')
								->setRef("/api/v31/components/schemas/petdetails#pet_details_id"),
						)
						->addProperty(
							"petDetails",
							(new Schema())
								->setRef("/api/v31/components/schemas/petdetails"),
						)
						->markFieldsAsRequired("name", "photoUrls")
						->addCustomAttribute("xml", [
							"name" => "Pet",
						]),
				)
				->addSchema(
					"PetDetails",
					(new Schema())
						->addCustomAttribute('$id', '/api/v31/components/schemas/petdetails')
						->addCustomAttribute('$schema', 'https://json-schema.org/draft/2020-12/schema')
						->addCustomAttribute('$vocabulary', 'https://spec.openapis.org/oas/3.1/schema-base')
						->addCustomAttribute('xml', [
							"name" => "PetDetails",
						])
						->addProperty(
							"id",
							(new Schema())
								->setType("integer")
								->setFormat("int64")
								->addCustomAttribute('$anchor', "pet_details_id")
								->setExamples(["10"]),
						)
						->addProperty(
							"category",
							(new Schema())
								->setRef("/api/v31/components/schemas/category")
								->setDescription("PetDetails Category"),
						)
						->addProperty(
							"tag",
							(new Schema())
								->setRef("/api/v31/components/schemas/tag"),
						),
				)
				->addSchema(
					"Tag",
					(new Schema())
						->addCustomAttribute('$id', '/api/v31/components/schemas/tag')
						->addCustomAttribute('xml', [
							"name" => "Tag",
						])
						->addProperty(
							"id",
							(new Schema())
								->setType("integer")
								->setFormat("int64"),
						)
						->addProperty(
							"name",
							(new Schema())
								->setType("string"),
						),
				)
				->addSecurityScheme(
					"petstore_auth",
					(new SecurityScheme())
						->setType("oauth2")
						->setOAuthFlows(
							(new OAuthFlows())
								->setImplicit(
									(new OAuthFlow())
										->setAuthorizationUrl("https://petstore31.swagger.io/oauth/authorize")
										->addScope("write:pets", "modify pets in your account")
										->addScope("read:pets", "read your pets"),
								),
						),
				)
				->addSecurityScheme(
					"mutual_tls",
					(new SecurityScheme())
						->setType("mutualTLS"),
				)
				->addSecurityScheme(
					"api_key",
					(new SecurityScheme())
						->setType("apiKey")
						->setName("api_key")
						->setIn("header"),
				),
		);
		$doc->addWebhook(
			"newPet",
			(new PathItem())
				->setPost(
					(new Operation())
						->setRequestBody(
							(new RequestBody())
								->setDescription("Information about a new pet in the system")
								->addMediaType(
									"application/json",
									(new MediaType())
										->setSchema(
											(new Schema())
												->setRef("#/components/schemas/Pet")
												->setDescription("Webhook Pet"),
										),
								),
						)
						->addResponse(
							"200",
							(new Response())
								->setDescription("Return a 200 status to indicate that the data was received successfully"),
						),
				),
		);

		$this->assertJsonStringEqualsJsonFile(
			__DIR__ . '/examples/petstore.json',
			$doc->toJson(new MarshallingContext()),
		);
	}
}

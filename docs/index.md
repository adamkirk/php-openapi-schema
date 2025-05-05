---
hide:
  - toc
  - navigation
---
# Home

This package aims to be an OOP representation of an Open API schema for php, to help build schemas programmatically. Take a look at the example below to get a quick idea of how this can be used to build API specs in PHP.

??? example "Example"

    === "PHP Code"
        ```php
        use OpenApiSchema\Document;
        use OpenApiSchema\Server\Server;
        use OpenApiSchema\Operations\Schema;
        use OpenApiSchema\Operations\PathItem;
        use OpenApiSchema\Operations\Response;
        use OpenApiSchema\Operations\MediaType;
        use OpenApiSchema\Operations\Operation;
        use OpenApiSchema\Operations\Parameter;
        use OpenApiSchema\Spec\MarshallingContext;
        use OpenApiSchema\Operations\RequestBody;

        $doc = new Document;

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

        $json = $doc->toJson(new MarshallingContext);
        ```

    === "JSON schema"
        ```json
        {
            "openapi": "3.1.0",
            "info": {
                "title": "Example API",
                "summary": "A very basic API",
                "description": "An example API using the OpenApiSchema components",
                "version": "1.0.0"
            },
            "servers": [
                {
                    "url": "/api/v1"
                }
            ],
            "paths": {
                "/v1/resource/{id}": {
                    "put": {
                        "summary": "Update a resource",
                        "description": "Update a resource by Id.",
                        "parameters": [
                            {
                                "name": "id",
                                "in": "path",
                                "required": true,
                                "schema": {
                                    "type": "integer"
                                }
                            }
                        ],
                        "requestBody": {
                            "description": "Resource data structure",
                            "content": {
                                "application/json": {
                                    "schema": {
                                        "properties": {
                                            "name": {
                                                "type": "string"
                                            }
                                        }
                                    }
                                }
                            },
                            "required": true
                        },
                        "responses": {
                            "200": {
                                "description": "Successful operation",
                                "content": {
                                    "application/json": {
                                        "schema": {
                                            "properties": {
                                                "id": {
                                                    "type": "integer"
                                                },
                                                "name": {
                                                    "type": "string"
                                                }
                                            }
                                        }
                                    }
                                }
                            },
                            "404": {
                                "description": "resource not found"
                            }
                        }
                    }
                }
            },
            "components": {}
        }   
        ```
# User Guide

How to use this library?

## Quickstart

...

## Building a spec

We won't go through every option here, as the library is pretty uniform, once you can configure a few basic properties you can use the [Reference](../reference/){target=blank} to figure out how the spec can be composed.

??? tip "Show JSON"
    At any point during this guide you can run `$doc->toJson()` to get the spec in a JSON format. You can paste that into the [Swagger editor](https://editor-next.swagger.io/){target=blank} for a quick way to visualise it.

    *You may get some validation errors until step 3, but after that this should be a valid spec.*

*All the setters in the library are fluent, which can make it pretty convenient to build things in less lines. You can also opt not to use this, we'll highlight this in the first couple of sections, but then we'll use the fluent setters for the rest. Largely this is just preference, but the fluency can be pretty handy to avoid extra lines of code and intermediary variables.*


### 1. Setup document

Firstly we'll setup the document and define the openapi schema version it's using.

!!! example
    === "Fluent setters"
        ```php
        use OpenApiSchema as OA;
        $doc = (new OA\Document)->setOpenapi("3.1.0"); // JSON path `.openapi`
        ```

    === "Without using Fluent setters"
        ```php
        use OpenApiSchema as OA;
        $doc = new OA\Document;
        $doc->setOpenapi("3.1.0"); // JSON path `.openapi`
        ```

### 2. Set some meta info

We'll set the title, description, and version for the API. This is done via the `Meta\Info` class, which we can then set on the document.

!!! example
    === "Fluent setters"
        ```php
        $doc->setInfo(
            (new OA\Meta\Info)
                ->setVersion("1.0.0") // JSON path `.info.version`
                ->setTitle("My API") // JSON path `.info.title`
                ->setDescription("An API that does things") // JSON path `.info.description`
        );
        ```

    === "Without using Fluent setters"
        ```php
        $info = new OA\Meta\Info;
        $info->setVersion("1.0.0"); // JSON path `.info.version`
        $info->setTitle("My API"); // JSON path `.info.title`
        $info->setDescription("An API that does things"); // JSON path `.info.description`

        $doc->setInfo($info); // set the info object on the document 
        ```

### 3. Add a list endpoint

Typically the core thing within an OpenApi Spec, we'll add a path item with a single operation.


!!! example
    ```php
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
                        (new OA\Operations\Response) // JSON path `.paths[/api/v1/users].get.responses[400]`
                            ->setDescription("One of the query parameters was invalid") // JSON path `.paths[/api/v1/users].get.responses[400].description`
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
                                                            ->setType("integer") // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.id.type`
                                                    ) 
                                                    ->addProperty(
                                                        "name", // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.name`
                                                        (new OA\Operations\Schema())
                                                            ->setType("string") // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.name.type`
                                                    )
                                                    ->addProperty(
                                                        "email",  // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.email`
                                                        (new OA\Operations\Schema())
                                                            ->setType("string")  // JSON path `.paths[/api/v1/users].get.responses[200].content[application/json].schema.items.properties.email.type`
                                                    ),
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
    ```

### 4. Add a component

It's a little tedious building out the same spec each time so we'll add a component for our `user` object.

!!! example
    ```php
        $doc->setComponents( // JSON path `.components`
            (new OA\Components\Components)
                ->addSchema(
                    "user",  // JSON path `.components.schemas.user`
                    (new OA\Operations\Schema)
                        ->addProperty(
                            "id",  // JSON path `.components.schemas.user.properties.id`
                            (new OA\Operations\Schema)
                                ->setType("integer") // JSON path `.components.schemas.user.properties.id.type`
                                ->setExclusiveMinimum(0) // JSON path `.components.schemas.user.properties.id.exclusiveMinimum`
                        )
                        ->addProperty(
                            "name", // JSON path `.components.schemas.user.properties.name`
                            (new OA\Operations\Schema)
                                ->setType("string") // JSON path `.components.schemas.user.properties.name.type`
                        )
                        ->addProperty(
                            "email", // JSON path `.components.schemas.user.properties.email`
                            (new OA\Operations\Schema)
                                ->setType("string") // JSON path `.components.schemas.user.properties.email.type`
                        )
                )
        );
    ```

### 5. Add GET/PUT/DELETE user

Now we'll add some another path item with 3 operations, to handle retrieving, creating and deleting users.

!!! example
    ```php
    $doc->addPathItem(
        "/api/v1/users/{id}", // JSON path `.paths[/api/v1/users/{id}]`
        (new OA\Operations\PathItem)
            ->addParameters(
                (new OA\Operations\Parameter) // JSON path `.paths[/api/v1/users/{id}].parameters[0]`
                    ->setName("id") // JSON path `.paths[/api/v1/users/{id}].parameters[0].name`
                    ->setIn("path") // JSON path `.paths[/api/v1/users/{id}].parameters[0].in`
                    ->isRequired() // JSON path `.paths[/api/v1/users/{id}].parameters[0].required`
                    ->setSchema(
                        (new OA\Operations\Schema) // JSON path `.paths[/api/v1/users/{id}].parameters[0].schema`
                            ->setType("integer") // JSON path `.paths[/api/v1/users/{id}].parameters[0].schema.type`
                    )
            )
            ->setGet(
                (new OA\Operations\Operation) // JSON path `.paths[/api/v1/users/{id}].get`
                    ->setDescription("Get a user") // JSON path `.paths[/api/v1/users/{id}].get.description`
                    ->addResponse(
                        "200", // JSON path `.paths[/api/v1/users/{id}].get.responses[200]`
                        (new OA\Operations\Response)
                            ->setDescription("The user.") // JSON path `.paths[/api/v1/users/{id}].get.responses[200].description`
                            ->addMediaType(
                                "application/json",  // JSON path `.paths[/api/v1/users/{id}].get.responses[200].content[application/json]`
                                (new OA\Operations\MediaType)
                                    ->setSchema(
                                        (new OA\Operations\Schema) // JSON path `.paths[/api/v1/users/{id}].get.responses[200].content[application/json].schema`
                                            ->setRef("#/components/schemas/user") // JSON path `.paths[/api/v1/users/{id}].get.responses[200].content[application/json].schema.$ref`
                                    )
                            )
                    )
            )
            ->setPut(
                (new OA\Operations\Operation) // JSON path `.paths[/api/v1/users/{id}].put`
                    ->setDescription("Get a user") // JSON path `.paths[/api/v1/users/{id}].put.description`
                    ->setRequestBody(
                        (new OA\Operations\RequestBody) // JSON path `.paths[/api/v1/users/{id}].put.requestBody`
                            ->addMediaType(
                                "application/json", // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json]`
                                (new OA\Operations\MediaType)
                                    ->setSchema(
                                        (new OA\Operations\Schema)  // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema`
                                            ->addProperty(
                                                "name",  // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.name`
                                                (new OA\Operations\Schema)
                                                    ->setType("string"), // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.name.type`
                                            )
                                            ->addProperty(
                                                "email", // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.email`
                                                (new OA\Operations\Schema)
                                                    ->setType("string"), // JSON path `.paths[/api/v1/users/{id}].put.requestBody.content[application/json].schema.properties.email.type`
                                            )
                                    )
                            )
                    )
                    ->addResponse(
                        "200", // JSON path `.paths[/api/v1/users/{id}].put.responses[200]`
                        (new OA\Operations\Response)
                            ->setDescription("The user.") // JSON path `.paths[/api/v1/users/{id}].put.responses[200].description`
                            ->addMediaType(
                                "application/json",  // JSON path `.paths[/api/v1/users/{id}].put.responses[200].content[application/json]`
                                (new OA\Operations\MediaType)
                                    ->setSchema(
                                        (new OA\Operations\Schema) // JSON path `.paths[/api/v1/users/{id}].put.responses[200].content[application/json].schema`
                                            ->setRef("#/components/schemas/user") // JSON path `.paths[/api/v1/users/{id}].put.responses[200].content[application/json].schema.$ref`
                                    )
                            )
                    )
            )
            ->setDelete(
                (new OA\Operations\Operation) // JSON path `.paths[/api/v1/users/{id}].delete`
                    ->setDescription("Delete a user") // JSON path `.paths[/api/v1/users/{id}].delete.description`
                    ->addResponse( 
                        "204", // JSON path `.paths[/api/v1/users/{id}].delete.responses[204]`
                        (new OA\Operations\Response)
                            ->setDescription("user successfully deleted (no content)") // JSON path `.paths[/api/v1/users/{id}].delete.responses[204].description`
                    )
            )
        );
    ```

### 6. Get the JSON spec

Now we'll get the JSON spec for you to use.

??? note "MarshallingContext"
    The `MarshallingContext` is not actually doing anything yet, the intention is too allow customisation of how any object is marshalled by adding properties to this.

!!! example
    ```php
    $jsonSpec = $doc->toJson(new OA\Spec\MarshallingContext());
    ```

*[< Back](../)*
<?php

declare(strict_types=1);

namespace Tests\Unit\Spec;

use stdClass;
use OpenApiSchema\Document;
use OpenApiSchema\Meta\Tag;
use OpenApiSchema\Meta\Info;
use OpenApiSchema\Meta\Tags;
use PHPUnit\Framework\TestCase;
use OpenApiSchema\Server\Server;
use OpenApiSchema\Server\Servers;
use OpenApiSchema\Operations\PathItem;
use OpenApiSchema\Operations\PathItems;
use OpenApiSchema\Components\Components;
use OpenApiSchema\Spec\MarshallingContext;
use PHPUnit\Framework\MockObject\MockObject;
use OpenApiSchema\Meta\ExternalDocumentation;
use OpenApiSchema\Security\SecurityRequirement;
use OpenApiSchema\Security\SecurityRequirements;

/**
 * @covers Document
 */
class DocumentTest extends TestCase
{
	public function test_nothing_is_set(): void
	{
		/** @var MarshallingContext|MockObject */
		$ctx = $this->createMock(MarshallingContext::class);
		$doc = new Document();

		$this->assertEqualsCanonicalizing(
			json_encode(["components" => new stdClass()], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
			$doc->toJson($ctx),
		);
	}

	public function test_getters_and_setters(): void
	{
		$doc = new Document();

		// Openapi
		$this->assertEquals(null, $doc->getOpenapi());
		$doc->setOpenapi('3.0.0');
		$this->assertEquals('3.0.0', $doc->getOpenapi());

		// Info
		$this->assertEquals(null, $doc->getInfo());
		/** @var Info|MockObject $info */
		$info = $this->createMock(Info::class);
		$doc->setInfo($info);
		$this->assertSame($info, $doc->getInfo());

		// JsonSchemaDialect
		$this->assertEquals(null, $doc->getJsonSchemaDialect());
		$doc->setJsonSchemaDialect('blah');
		$this->assertSame('blah', $doc->getJsonSchemaDialect());

		// Servers
		$this->assertTrue($doc->getServers()->isEmpty());
		/** @var Server|MockObject $server1 */
		$server1 = $this->createMock(Server::class);
		/** @var Server|MockObject $server2 */
		$server2 = $this->createMock(Server::class);
		/** @var Servers|MockObject $servers */
		$servers = $this->createMock(Servers::class);
		$doc->addServers($server1, $server2);
		$this->assertEquals((new Servers())->add($server1, $server2), $doc->getServers());
		$doc->setServers($servers);
		$this->assertSame($servers, $doc->getServers());

		// Paths
		$this->assertTrue($doc->getPathItems()->isEmpty());
		/** @var PathItem|MockObject $pathItem1 */
		$pathItem1 = $this->createMock(PathItem::class);
		/** @var PathItem|MockObject $pathItem2 */
		$pathItem2 = $this->createMock(PathItem::class);
		/** @var PathItems|MockObject $pathItems */
		$pathItems = $this->createMock(PathItems::class);
		$doc->addPathItem('path_1', $pathItem1);
		$doc->addPathItem('path_2', $pathItem2);
		$this->assertEquals(
			(new PathItems())
				->add('path_1', $pathItem1)
				->add('path_2', $pathItem2),
			$doc->getPathItems(),
		);
		$doc->setPathItems($pathItems);
		$this->assertSame($pathItems, $doc->getPathItems());

		// Components
		$this->assertInstanceOf(Components::class, $doc->getComponents());
		/** @var Components|MockObject $components */
		$components = $this->createMock(Components::class);
		$this->assertNotSame($components, $doc->getComponents());
		$doc->setComponents($components);
		$this->assertSame($components, $doc->getComponents());

		// Webhooks
		$this->assertTrue($doc->getWebhooks()->isEmpty());
		/** @var PathItem|MockObject $webhook1 */
		$webhook1 = $this->createMock(PathItem::class);
		/** @var PathItem|MockObject $webhook2 */
		$webhook2 = $this->createMock(PathItem::class);
		/** @var PathItems|MockObject $webhooks */
		$webhooks = $this->createMock(PathItems::class);
		$doc->addWebhook("webhook_1", $webhook1);
		$doc->addWebhook("webhook_2", $webhook2);
		$this->assertEquals(
			(new PathItems())
				->add('webhook_1', $webhook1)
				->add('webhook_2', $webhook2),
			$doc->getWebhooks(),
		);
		$doc->setWebhooks($webhooks);
		$this->assertSame($webhooks, $doc->getWebhooks());

		// Security
		$this->assertTrue($doc->getSecurityRequirements()->isEmpty());
		/** @var SecurityRequirement|MockObject $secReq1 */
		$secReq1 = $this->createMock(SecurityRequirement::class);
		/** @var SecurityRequirement|MockObject $secReq2 */
		$secReq2 = $this->createMock(SecurityRequirement::class);
		/** @var SecurityRequirements|MockObject $secReqs */
		$secReqs = $this->createMock(SecurityRequirements::class);
		$doc->addSecurityRequirement('req_1', $secReq1);
		$doc->addSecurityRequirement('req_2', $secReq2);
		$this->assertEquals(
			(new SecurityRequirements())
				->add('req_1', $secReq1)
				->add('req_2', $secReq2),
			$doc->getSecurityRequirements(),
		);

		$doc->setSecurityRequirements($secReqs);
		$this->assertSame($secReqs, $doc->getSecurityRequirements());

		// Tags
		$this->assertTrue($doc->getTags()->isEmpty());
		/** @var Tag|MockObject $tag1 */
		$tag1 = $this->createMock(Tag::class);
		/** @var Tag|MockObject $tag2 */
		$tag2 = $this->createMock(Tag::class);
		/** @var Tags|MockObject $tags */
		$tags = $this->createMock(Tags::class);
		$doc->addTags($tag1, $tag2);
		$this->assertEquals(
			(new Tags())->add($tag1, $tag2),
			$doc->getTags(),
		);
		$doc->setTags($tags);
		$this->assertSame($tags, $doc->getTags());

		// External docs
		$this->assertNull($doc->getExternalDocs());
		/** @var ExternalDocumentation|MockObject $extDoc */
		$extDoc = $this->createMock(ExternalDocumentation::class);
		$doc->setExternalDocs($extDoc);
		$this->assertSame($extDoc, $doc->getExternalDocs());
		$doc->setExternalDocs(null);
		$this->assertNull($doc->getExternalDocs());
	}

	public function test_to_json_when_everything_is_set(): void
	{
		/** @var MarshallingContext|MockObject */
		$ctx = $this->createMock(MarshallingContext::class);

		/** @var Info|MockObject */
		$info = $this->createMock(Info::class);
		$info->expects($this->any())->method('toMarshallable')->willReturn([
			'component' => 'info',
		]);

		/** @var Server|MockObject */
		$server1 = $this->createMock(Server::class);
		$server1->expects($this->any())->method('toMarshallable')->willReturn(['server' => '1']);

		/** @var Server|MockObject */
		$server2 = $this->createMock(Server::class);
		$server2->expects($this->any())->method('toMarshallable')->willReturn(['server' => '2']);

		/** @var PathItem|MockObject */
		$pathItem1 = $this->createMock(PathItem::class);
		$pathItem1->expects($this->any())->method('toMarshallable')->willReturn(['pathItem' => '1']);

		/** @var PathItem|MockObject */
		$pathItem2 = $this->createMock(PathItem::class);
		$pathItem2->expects($this->any())->method('toMarshallable')->willReturn(['pathItem' => '2']);

		/** @var Components|MockObject */
		$components = $this->createMock(Components::class);
		$components->expects($this->any())->method('toMarshallable')->willReturn(['component' => 'components']);


		/** @var SecurityRequirement|MockObject */
		$secRequirement1 = $this->createMock(SecurityRequirement::class);
		$secRequirement1->expects($this->any())->method('toMarshallable')->willReturn(['secreq' => '1']);

		/** @var SecurityRequirement|MockObject */
		$secRequirement2 = $this->createMock(SecurityRequirement::class);
		$secRequirement2->expects($this->any())->method('toMarshallable')->willReturn(['secreq' => '2']);

		/** @var Tag|MockObject */
		$tag1 = $this->createMock(Tag::class);
		$tag1->expects($this->any())->method('toMarshallable')->willReturn(['tag' => '1']);

		/** @var Tag|MockObject */
		$tag2 = $this->createMock(Tag::class);
		$tag2->expects($this->any())->method('toMarshallable')->willReturn(['tag' => '2']);

		/** @var ExternalDocumentation|MockObject */
		$extDoc = $this->createMock(ExternalDocumentation::class);
		$extDoc->expects($this->any())->method('toMarshallable')->willReturn(['component' => 'extdoc']);

		/** @var PathItem|MockObject */
		$webhook1 = $this->createMock(PathItem::class);
		$webhook1->expects($this->any())->method('toMarshallable')->willReturn(['webhook' => '1']);

		/** @var PathItem|MockObject */
		$webhook2 = $this->createMock(PathItem::class);
		$webhook2->expects($this->any())->method('toMarshallable')->willReturn(['webhook' => '2']);

		$doc = new Document();
		$doc->setOpenapi("3.0.0")
			->setInfo($info)
			->setJsonSchemaDialect("some/dialect")
			->addServers($server1, $server2)
			->addPathItem('path_1', $pathItem1)
			->addPathItem('path_2', $pathItem2)
			->setComponents($components)
			->addSecurityRequirement('req_1', $secRequirement1)
			->addSecurityRequirement('req_2', $secRequirement2)
			->addTags($tag1, $tag2)
			->setExternalDocs($extDoc)
			->addWebhook('webhook_1', $webhook1)
			->addWebhook('webhook_2', $webhook2)
			->addCustomAttribute('some-custom-key', ['some', 'values'])
			->addCustomAttribute('other-custom-key', 'some-string');

		$this->assertEquals(
			json_encode([
				'openapi' => '3.0.0',
				'info' => [
					'component' => 'info',
				],
				'jsonSchemaDialect' => 'some/dialect',
				'externalDocs' => [
					'component' => 'extdoc',
				],
				'servers' => [
					['server' => '1'],
					['server' => '2'],
				],
				'paths' => [
					'path_1' => ['pathItem' => '1'],
					'path_2' => ['pathItem' => '2'],
				],
				'components' => [
					'component' => 'components',
				],
				'webhooks' => [
					'webhook_1' => [
						'webhook' => '1',
					],
					'webhook_2' => [
						'webhook' => '2',
					],
				],
				'security' => [
					'req_1' => ['secreq' => '1'],
					'req_2' => ['secreq' => '2'],
				],
				'tags' => [
					['tag' => '1'],
					['tag' => '2'],
				],
				'some-custom-key' => ['some', 'values'],
				'other-custom-key' => 'some-string',
			], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
			$doc->toJson($ctx),
		);
	}
}

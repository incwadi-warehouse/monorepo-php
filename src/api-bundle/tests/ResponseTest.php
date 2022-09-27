<?php

namespace Baldeweg\Bundle\ApiBundle\Tests;

use Baldeweg\Bundle\ApiBundle\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Baldeweg\Bundle\ApiBundle\Serializer;

class ResponseTest extends TestCase
{
    public function testSingle()
    {
        $child = $this
            ->getMockBuilder(\stdClass::class)
            ->addMethods(['getTitle'])
            ->getMock();
        $child->method('getTitle')->willReturn('title');

        $entity = $this
            ->getMockBuilder(\stdClass::class)
            ->addMethods(['getTest', 'getDateTimestamp', 'getChild', 'getItemsCounter'])
            ->getMock();
        $entity->method('getTest')->willReturn('test');
        $entity->method('getDateTimestamp')->willReturn(1);
        $entity->method('getChild')->willReturn($child);
        $entity->method('getItemsCounter')->willReturn(2);

        $fields = ['test', 'dateTimestamp', 'child' => ['title'], 'itemsCounter'];

        $response = new Response();
        $res = $response->single($fields, $entity);

        $this->assertInstanceOf(JsonResponse::class, $res);
        $content = json_decode($res->getContent(),true);
        $this->assertIsArray($content);
        $this->assertEquals('test', $content['test']);
        $this->assertIsInt($content['dateTimestamp']);
        $this->assertEquals('title', $content['child']['title']);
        $this->assertEquals(2, $content['itemsCounter']);
    }

    public function testCollection()
    {
        $serializer = $this
            ->getMockBuilder(Serializer::class)
            ->getMock();

        $fields = ['test', 'dateTimestamp', 'child' => ['title'], 'itemsCounter'];

        $response = new Response($serializer);
        $res = $response->collection($fields, []);

        $this->assertInstanceOf(JsonResponse::class, $res);
    }

    public function testInvalid()
    {
        $serializer = $this
            ->getMockBuilder(Serializer::class)
            ->getMock();

        $response = new Response($serializer);
        $res = $response->invalid();

        $this->assertInstanceOf(JsonResponse::class, $res);
    }

    public function testDeleted()
    {
        $serializer = $this
            ->getMockBuilder(Serializer::class)
            ->getMock();

        $response = new Response($serializer);
        $res = $response->deleted();

        $this->assertInstanceOf(JsonResponse::class, $res);
    }
}

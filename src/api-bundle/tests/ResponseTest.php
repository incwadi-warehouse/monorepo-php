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
        $serializer = $this
            ->getMockBuilder(Serializer::class)
            ->getMock();

        $fields = ['test', 'date:timestamp', 'child.title', 'items:count'];

        $response = new Response($serializer);
        $res = $response->single($fields, []);

        $this->assertInstanceOf(JsonResponse::class, $res);
    }

    public function testCollection()
    {
        $serializer = $this
            ->getMockBuilder(Serializer::class)
            ->getMock();

        $fields = ['test', 'date:timestamp', 'child.title', 'items:count'];

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

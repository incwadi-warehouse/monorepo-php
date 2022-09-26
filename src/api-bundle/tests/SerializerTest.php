<?php

namespace Baldeweg\Bundle\ApiBundle\Tests;

use Baldeweg\Bundle\ApiBundle\Serializer;
use PHPUnit\Framework\TestCase;

class SerializerTest extends TestCase
{
    public function testSerializer()
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

        $fields = ['test', 'dateTimestamp', 'child.title', 'itemsCounter'];

        $serializer = new Serializer();

        $response = $serializer->serialize($entity, $fields);

        $this->assertIsArray($response);
        $this->assertEquals('test', $response['test']);
        $this->assertIsInt($response['dateTimestamp']);
        $this->assertEquals('title', $response['child_title']);
        $this->assertEquals(2, $response['itemsCounter']);
    }
}

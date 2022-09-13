<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests\Command;

use PHPUnit\Framework\TestCase;
use Baldeweg\Bundle\ExtraBundle\Command\ListUserCommand;
use Symfony\Component\Console\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ListUserCommandTest extends TestCase
{
    public function testExecute()
    {
        $em = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $params = $this->getMockBuilder(ParameterBagInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();
        $application->add(new ListUserCommand($em, $params));
        $command = $application->find('user:list');

        $this->assertEquals(
            'user:list',
            $command->getName(),
            'ListUserCommandTest user:list'
        );
    }
}

<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests\Command;

use PHPUnit\Framework\TestCase;
use Baldeweg\Bundle\ExtraBundle\Command\DeleteUserCommand;
use Symfony\Component\Console\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DeleteUserCommandTest extends TestCase
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
        $application->add(new DeleteUserCommand($em, $params));
        $command = $application->find('user:delete');

        $this->assertEquals(
            'user:delete',
            $command->getName(),
            'DeleteUserCommandTest user:delete'
        );
    }
}

<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests\Command;

use Baldeweg\Bundle\ExtraBundle\Command\NewUserCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class NewUserCommandTest extends TestCase
{
    public function testExecute()
    {
        $em = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $encoder = $this->getMockBuilder(UserPasswordHasherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $params = $this->getMockBuilder(ParameterBagInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();
        $application->add(new NewUserCommand($em, $encoder, $params));
        $command = $application->find('user:new');

        $this->assertEquals(
            'user:new',
            $command->getName(),
            'NewUserCommandTest user:new'
        );
    }
}

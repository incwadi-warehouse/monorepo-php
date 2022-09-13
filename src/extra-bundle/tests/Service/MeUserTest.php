<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests;

use Baldeweg\Bundle\ExtraBundle\Service\MeUser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MeUserTest extends TestCase
{
    public function testMeUser()
    {
        $user = $this->getMockBuilder(UserInterface::class)
            ->addMethods(['getId', 'getPassword', 'getSalt', 'getUsername'])
            ->onlyMethods(['getRoles', 'eraseCredentials', 'getUserIdentifier'])
            ->disableOriginalConstructor()
            ->getMock();
        $user->method('getId')
            ->willReturn('1');
        $user->method('getUserIdentifier')
            ->willReturn('admin');
        $user->method('getRoles')
            ->willReturn(['ROLE_USER']);

        $token = $this->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token->method('getUser')
            ->willReturn($user);

        $tokenStorage = $this->getMockBuilder(TokenStorageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tokenStorage->method('getToken')
            ->willReturn($token);

        $auth = $this->getMockBuilder(AuthorizationCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $auth->method('isGranted')
            ->willReturn(true);

        $me = new MeUser($tokenStorage, $auth);

        $response = json_decode($me->me()->getContent());

        $this->assertIsObject($response);
        $this->assertIsString($response->id);
        $this->assertIsString($response->username);
        $this->assertIsArray($response->roles);
        $this->assertIsBool($response->isUser);
        $this->assertIsBool($response->isAdmin);
    }
}

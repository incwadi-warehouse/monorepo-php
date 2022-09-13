<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests;

use Baldeweg\Bundle\ExtraBundle\Service\PasswordUser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Prophecy\PhpUnit\ProphecyTrait;

class PasswordUserTest extends TestCase
{
    use ProphecyTrait;

    public function testPasswordUser()
    {
        $auth = $this->prophesize(UserInterface::class)
            ->willImplement(PasswordAuthenticatedUserInterface::class)->reveal();

        $user = $this->getMockBuilder($auth::class)
            ->addMethods(['getId', 'setPassword', 'getSalt', 'getUsername'])
            ->onlyMethods(['getUserIdentifier', 'getRoles', 'eraseCredentials', 'getPassword'])
            ->disableOriginalConstructor()
            ->getMock();
        $user->method('getPassword')
            ->willReturn('password');

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

        $encoder = $this->getMockBuilder(UserPasswordHasherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $encoder->method('hashPassword')
            ->willReturn('password');

        $object = $this->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $manager->method('getManager')
            ->willReturn($object);

        $formInterface = $this->getMockBuilder(FormInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $formInterface->method('isSubmitted')
            ->willReturn(true);
        $formInterface->method('isValid')
            ->willReturn(true);

        $form = $this->getMockBuilder(FormFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $form->method('create')
            ->willReturn($formInterface);

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->method('getContent')
            ->willReturn('{}');

        $password = new PasswordUser($tokenStorage, $auth, $encoder, $manager, $form);

        $response = json_decode($password->password($request)->getContent());

        $this->assertIsObject($response);
    }
}

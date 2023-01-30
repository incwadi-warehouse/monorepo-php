<?php

namespace Baldeweg\Bundle\ExtraBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MeUser
{
    public function __construct(private readonly TokenStorageInterface $token, private readonly AuthorizationCheckerInterface $auth)
    {
    }
    
    protected function isGranted($attribute, $subject = null): bool
    {
        return $this->auth->isGranted($attribute, $subject);
    }

    public function me(): JsonResponse
    {
        if (!$this->auth->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $user = $this->token->getToken()->getUser();

        return new JsonResponse(
            [
                'id' => $user->getId(),
                'username' => $user->getUserIdentifier(),
                'roles' => $user->getRoles(),
                'isUser' => $this->isGranted('ROLE_USER'),
                'isAdmin' => $this->isGranted('ROLE_ADMIN'),
            ]
        );
    }
}

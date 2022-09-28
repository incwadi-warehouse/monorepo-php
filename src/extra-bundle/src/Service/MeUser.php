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

    protected function getUser()
    {
        return $this->token->getToken()->getUser();
    }

    protected function isGranted($attribute, $subject = null): bool
    {
        return $this->auth->isGranted($attribute, $subject);
    }

    public function me(): JsonResponse
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        return new JsonResponse(
            [
                'id' => $this->getUser()->getId(),
                'username' => $this->getUser()->getUserIdentifier(),
                'roles' => $this->getUser()->getRoles(),
                'isUser' => $this->isGranted('ROLE_USER'), // @deprecated
                'isAdmin' => $this->isGranted('ROLE_ADMIN'), // @deprecated
            ]
        );
    }
}

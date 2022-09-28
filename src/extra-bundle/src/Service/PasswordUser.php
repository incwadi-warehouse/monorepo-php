<?php

namespace Baldeweg\Bundle\ExtraBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Baldeweg\Bundle\ExtraBundle\Form\PasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class PasswordUser
{
    public function __construct(private readonly TokenStorageInterface $token, private readonly AuthorizationCheckerInterface $auth, private readonly UserPasswordHasherInterface $encoder, private readonly ManagerRegistry $registry, private readonly FormFactoryInterface $form)
    {
    }

    public function password(Request $request): JsonResponse
    {
        if (!$this->auth->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $user = $this->token->getToken()->getUser();

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $form = $this->form->create(PasswordType::class, $user);

        $form->submit(
            json_decode(
                $request->getContent(),
                true
            )
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->encoder->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );

            $this->registry->getManager()->flush();

            return new JsonResponse([
                'msg' => 'PASSWORD_CHANGED',
            ]);
        }

        return new JsonResponse([
            'msg' => 'PASSWORD_NOT_CHANGED',
        ], Response::HTTP_BAD_REQUEST);
    }
}

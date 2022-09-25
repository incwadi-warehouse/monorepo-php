<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApiController extends AbstractController
{
    protected function submitForm(Request $request): array
    {
        return json_decode(
            $request->getContent(),
            true
        );
    }
}

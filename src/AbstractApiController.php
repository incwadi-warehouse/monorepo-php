<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Baldeweg\Bundle\ApiBundle\Serializer;

abstract class AbstractApiController extends AbstractController
{
    protected function setResponse()
    {
        return new Response(new Serializer());
    }

    protected function submitForm(Request $request): array
    {
        return json_decode(
            $request->getContent(),
            true
        );
    }
}

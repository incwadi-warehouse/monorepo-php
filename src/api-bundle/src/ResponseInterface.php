<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseInterface
{
    public function single(array $fields, \stdClass $data): JsonResponse;

    public function collection(array $fields, array $data): JsonResponse;

    public function invalid(): JsonResponse;

    public function deleted(): JsonResponse;

}

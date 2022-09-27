<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class Response implements ResponseInterface
{
    public function single(array $fields, \stdClass $data): JsonResponse
    {
        return $this->response(
            $this->serialize($data, $fields)
        );
    }

    public function collection(array $fields, array $data): JsonResponse
    {
        $collection = [];
        foreach ($data as $item) {
            $collection[] = $this->serialize($item, $fields);
        }

        return $this->response($collection);
    }

    public function invalid(): JsonResponse
    {
        return $this->response(['msg' => 'NOT_VALID'], 400);
    }

    public function deleted(): JsonResponse
    {
        return $this->response(['msg' => 'DELETED']);
    }

    private function response(array $data, int $code = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse(
            json_encode($data),
            $code,
            $headers,
            true
        );
    }

    private function serialize($entity, array $fields): array
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);

        return $serializer->normalize(
            $entity,
            'json',
            [AbstractNormalizer::ATTRIBUTES => $fields]
        );
    }
}

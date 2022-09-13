<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{
    public function __construct(private readonly Serializer $serializer)
    {
    }

    public function single(array $fields, $data): JsonResponse
    {
        return $this->response(
            $this->serializer->serialize($data, $fields)
        );
    }

    public function collection(array $fields, array $data): JsonResponse
    {
        $collection = [];
        foreach ($data as $item) {
            $collection[] = $this->serializer->serialize($item, $fields);
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
}

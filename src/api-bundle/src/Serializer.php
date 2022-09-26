<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;

class Serializer implements SerializerInterface
{
    public function serialize($entity, array $fields): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $object = [];
        foreach ($fields as $field) {
            $property = $this->transformFieldName((string) $field);
            try {
                $object[$property] = $propertyAccessor->getValue($entity, (string) $field);
            } catch (UnexpectedTypeException) {
                $object[$property] = null;
            }
        }

        return $object;
    }

    private function transformFieldName(string $field): string
    {
        return str_replace('.', '_', $field);
    }
}

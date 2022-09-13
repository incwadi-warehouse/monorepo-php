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
            $item = explode(':', (string) $field);

            $property = $this->transformFieldName($item[0]);
            try {
                $value = $this->transformValue(
                    isset($item[1]) ? $item[1] : null,
                    $propertyAccessor->getValue($entity, $item[0])
                );

                $object[$property] = $value;
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

    private function transformValue(?string $type = null, $value = null)
    {
        if ('timestamp' === $type && $value instanceof \DateTime) {
            $value = $value->getTimestamp();
        }

        if ('count' === $type) {
            $value = count($value);
        }

        return $value;
    }
}

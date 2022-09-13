<?php

namespace Baldeweg\Bundle\ApiBundle;

interface SerializerInterface
{
    public function serialize($entity, array $fields): array;
}

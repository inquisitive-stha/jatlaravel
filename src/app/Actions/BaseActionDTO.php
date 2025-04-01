<?php

namespace App\Actions;

class BaseActionDTO
{
    public function validateFields(array $requiredFields, array$data): void
    {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("The field $field is required.");
            }
        }
    }
}

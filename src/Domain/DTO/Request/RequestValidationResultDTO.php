<?php

namespace App\Domain\DTO\Request;

class RequestValidationResultDTO
{
    private bool $isValid;

    /**
     * @param array $errors
     */
    public function __construct(private array $errors) {
        $this->isValid = $this->errors === [];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    private array $errors;

    /**
     * @param array $messages
     */
    public function __construct(array $messages)
    {
        $this->errors = $messages;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
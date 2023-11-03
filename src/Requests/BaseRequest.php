<?php

namespace App\Requests;

use App\Domain\DTO\Request\RequestValidationResultDTO;
use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();

        $validate = $this->validate();

        if ($validate->isValid() === false) {
            throw new ValidationException($validate->getErrors());
        }
    }

    /**
     * @return RequestValidationResultDTO
     */
    private function validate(): RequestValidationResultDTO
    {
        $errors = $this->validator->validate($this);

        $messages = [];

        /** @var ConstraintViolation $errors */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        return new RequestValidationResultDTO($messages);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    /**
     * @return void
     */
    private function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
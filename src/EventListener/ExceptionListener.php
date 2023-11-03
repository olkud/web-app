<?php

namespace App\EventListener;

use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof ValidationException) {
            $this->handleValidationException($event, $throwable);
        }
    }

    /**
     * @param ExceptionEvent $event
     * @param ValidationException $exception
     * @return void
     */
    private function handleValidationException(ExceptionEvent $event, ValidationException $exception): void
    {
        $data = [
            'type' => 'validation_exception',
            'errors' => $exception->getErrors()
        ];
        $response = new JsonResponse($data, 422);

        $event->setResponse($response);
    }
}
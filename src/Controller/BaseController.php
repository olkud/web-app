<?php

namespace App\Controller;

use App\Domain\DTO\Request\RequestValidationResultDTO;
use App\Domain\Formatters\Formatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    /**
     * @param Formatter $formatter
     * @return Response
     */
    public function successResponse(Formatter $formatter): Response
    {
        return new JsonResponse($formatter->toArray());
    }
}
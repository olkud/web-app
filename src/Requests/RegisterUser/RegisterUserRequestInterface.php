<?php

namespace App\Requests\RegisterUser;

use App\Domain\DTO\User\RegisterUserDTO;

interface RegisterUserRequestInterface
{
    public function getDto(): RegisterUserDTO;
}
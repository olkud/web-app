<?php

namespace App\Requests\RegisterUser;

use App\Domain\DTO\User\RegisterUserDTO;
use App\Requests\BaseRequest;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegisterUserRequest extends BaseRequest
{
    #[Type(Types::STRING)]
    #[NotBlank()]
    protected $name;

    #[Type(Types::STRING)]
    #[NotBlank()]
    #[Email()]
    protected $email;

    #[Type(Types::STRING)]
    #[NotBlank()]
    #[GreaterThan(12)]
    protected $password;

    /**
     * @return RegisterUserDTO
     */
    public function getDto(): RegisterUserDTO
    {
        return new RegisterUserDTO(
            $this->name,
            $this->password,
            $this->email
        );
    }
}
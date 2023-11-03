<?php

namespace App\Domain\DTO\User;

class RegisterUserDTO
{
    /**
     * @param string $name
     * @param string $password
     * @param string $email
     */
    public function __construct(
        private string $name,
        private string $password,
        private string $email
    ) {}

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
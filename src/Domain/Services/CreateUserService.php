<?php

namespace App\Domain\Services;

use App\Domain\DTO\User\RegisterUserDTO;
use App\Domain\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class CreateUserService
{
    /**
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $hasher
    ) {}

    /**
     * @param RegisterUserDTO $dto
     * @return User
     */
    public function create(RegisterUserDTO $dto): User
    {
        $user = new User(
            Uuid::v4(),
            $dto->getName(),
            $dto->getEmail(),
            $dto->getPassword()
        );

        $hashedPassword = $this->hasher->hashPassword($user, $dto->getPassword());

        $user->setPassword($hashedPassword);

        $this->manager->persist($user);

        $this->manager->flush();

        return $user;
    }
}
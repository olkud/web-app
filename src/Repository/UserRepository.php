<?php

namespace App\Repository;

use App\Domain\Entities\User;

class UserRepository extends BaseRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder('user')->getQuery()->getResult();
    }
    public function findUserByApiKey(string $apiKey): User
    {
        $builder = $this->createQueryBuilder('users');

        $user = $builder
            ->select('users', 'feeds')
            ->leftJoin('users.feeds', 'feeds')
            ->where("users.apiKey = :key")
            ->setParameter('key', $apiKey)
            ->getQuery()
            ->getOneOrNullResult();

        if ($user === null) {
            throw new \Exception('User not found');
        }

        return $user;
    }
}

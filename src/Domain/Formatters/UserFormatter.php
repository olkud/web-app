<?php

namespace App\Domain\Formatters;

use App\Domain\Entities\User;

class UserFormatter implements Formatter
{
    /**
     * @param User $user
     */
    public function __construct(private User $user) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->user->getUuid(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()
        ];
    }
}
<?php

namespace App\Controller;

use App\Domain\Entities\User;
use App\Domain\Formatters\UserFormatter;
use App\Domain\Services\CreateUserService;
use App\Repository\UserRepository;
use App\Requests\RegisterUser\RegisterUserRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends BaseController
{
    /**
     * @param RegisterUserRequest $request
     * @param CreateUserService $service
     * @return Response
     */
    #[Route('/register', name: 'user_register', methods: ['POST'])]
    public function create(RegisterUserRequest $request, CreateUserService $service): Response
    {
        $user = $service->create($request->getDto());

        return $this->successResponse(
            new UserFormatter($user)
        );
    }

    #[Route('/api/users', name: 'users_list', methods: ['GET', 'HEAD'])]
    public function get(UserInterface $user)
    {
        /** @var User $user */
        return $this->successResponse(
            new UserFormatter($user)
        );
    }
}
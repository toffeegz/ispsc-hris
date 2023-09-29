<?php

namespace App\Services\User;
use App\Repositories\User\UserRepositoryInterface;

interface UserServiceInterface
{
    public function store(array $attributes);
}

<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{
    public function login(string $email, string $password, bool $is_google_auth);
    public function forgotPassword(string $email);
    public function resetPassword(string $token, string $password);
}

<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Log;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserServiceInterface;
use App\Repositories\Verification\VerificationRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $modelRepository;
    private VerificationRepositoryInterface $verificationRepository;

    public function __construct(
        UserRepositoryInterface $modelRepository,
        VerificationRepositoryInterface $verificationRepository,
    ) {
        $this->modelRepository = $modelRepository;
        $this->verificationRepository = $verificationRepository;
    }

    public function store(array $attributes)
    {
        try {
            $attributes['password'] = Hash::make(Str::random(64));
            $user = $this->modelRepository->create($attributes);

            if($user && isset($attributes['email'])) {
                $verification = $this->verificationRepository->createVerification($user->id, 'register');
                logger($verification);
                Mail::to($user->email)->send(new VerifyEmail($user, $verification['token']));
            }

            return $user;
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }
}

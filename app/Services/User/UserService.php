<?php

namespace App\Services\User;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use App\Repositories\Verification\VerificationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserServiceInterface;
use App\Mail\Auth\VerifyEmail;
use App\Mail\Auth\ForgotPasswordEmail;
use App\Models\PasswordResetToken;
use App\Models\Employee;
use App\Models\Role;

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
        DB::beginTransaction();

        try {
            $attributes['password'] = Hash::make(Str::random(64));
            $user = $this->modelRepository->create($attributes);

            if($user && isset($attributes['email'])) {

                $employee = Employee::find($attributes['employee_id'])
                    ->update(['user_id' => $user->id]);
                logger($employee);

                // Check if a token already exists for the email
                $existingToken = PasswordResetToken::where('email', $user->email)->first();

                // If a token exists, delete it
                if ($existingToken) {
                    $existingToken->delete();
                }

                $verification = $this->verificationRepository->createVerification($user->id, 'register');

                PasswordResetToken::insert([
                    'email' => $user->email,
                    'token' => $verification['token'], 
                    'created_at' => Carbon::now()
                ]);

                Mail::to($user->email)->send(new ForgotPasswordEmail($user, $verification['token'], $is_register = true));
                DB::commit();
    
                return $user;
            }

            return $user;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }

    public function update(array $attributes, $id)
    {
        DB::beginTransaction();

        try {
            $user = $this->modelRepository->update($attributes, $id);

            if($user && isset($attributes['email'])) {

                $employee = Employee::find($attributes['employee_id'])
                    ->update(['user_id' => $user->id]);
                logger($employee);

                DB::commit();
    
                return $user;
            }

            return $user;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }
}

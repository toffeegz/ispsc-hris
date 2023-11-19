<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Log;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\ForgotPasswordEmail;

use App\Models\PasswordResetToken;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $modelRepository;

    public function __construct(
        UserRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function login(string $email, string $password, bool $is_google_auth)
    {
        try 
        {
            $user = $this->modelRepository->getByEmail($email);
            if($user) {
                if($user->email_verified_at != null) {
                    if(Hash::check($password, $user->password) === true || $is_google_auth === true) {
                        Auth::login($user);
                        $creds = [
                            'token' => $user->createToken(config('app.name'))->plainTextToken,
                            'user' => $user,
                        ];
                        return $creds;
                    } else {
                        throw new AuthenticationException('Invalid credentials');
                    }
                } else {
                    throw new AuthorizationException('Account not verified');
                }
            } else {
                throw new AuthenticationException('Invalid credentials');
            }
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }

    public function forgotPassword(string $email)
    {
        $user = $this->modelRepository->getByEmail($email);
        
        if ($user) {
            $token = Str::random(60);
            PasswordResetToken::insert([
                'email' => $email,
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);

            Mail::to($user->email)->send(new ForgotPasswordEmail($user, $token));

            return 'Token generated and sent successfully';
        }

        throw new NotFoundException('User not found');
    }

    public function resetPassword(string $token, string $password)
    {
        $passwordReset = PasswordResetToken::where('token', $token)->first();

        if ($passwordReset) {
            // Check if token is expired or not
            if ($passwordReset->isExpired()) {
                throw new AuthenticationException('Token expired');
            }

            // Update user's password
            $user = $this->modelRepository->getByEmail($passwordReset->email);
            
            if ($user) {
                $user->password = Hash::make($password);
                $user->save();

                // Delete the token after successful password reset
                // Perform manual deletion by using query builder
                PasswordResetToken::where('token', $token)->delete();

                return 'Password reset successful';
            }
            
            throw new NotFoundException('User not found');
        }

        throw new AuthenticationException('Invalid token');
    }

    public function updateProfile(array $attributes)
    {
        try {
            $user = auth()->user(); // Get the authenticated user

            // Check if the current password is provided and matches the user's current password
            if (isset($attributes['current_password'])) {
                if (!Hash::check($attributes['current_password'], $user->password)) {
                    throw new AuthenticationException('Current password is incorrect');
                }

                // Update password if the current password is correct and new password is provided
                if (isset($attributes['password'])) {
                    $user->password = Hash::make($attributes['password']);
                }
            }

            // Update profile information if 'name' is provided
            if (isset($attributes['name'])) {
                $user->name = $attributes['name'];
            }

            // Save changes to the user model
            $user->save();

            return $user;
        } catch (\Exception $exception) {
            // Handle exceptions here or re-throw as needed
            throw $exception;
        }
    }

}
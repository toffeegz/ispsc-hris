<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Session\Store;
use Session;
use Illuminate\Support\Carbon;
use File; 
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

use App\Services\Utils\Response\ResponseServiceInterface;
use App\Services\Auth\AuthServiceInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\VerifyIdRequest;


class AuthController extends Controller
{
    private AuthServiceInterface $modelService;
    private UserRepositoryInterface $modelRepository;
    private ResponseServiceInterface $responseService;

    public function __construct(
        AuthServiceInterface $modelService,
        UserRepositoryInterface $modelRepository,
        ResponseServiceInterface $responseService,
    ) {
        $this->modelService = $modelService;
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function login(LoginRequest $request)
    {
        $result = $this->modelService->login($request->email, $request->password, false);
        return $this->responseService->resolveResponse("Login Successful", $result);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $google_user = Socialite::driver('google')->stateless()->user();

        $user = $this->modelRepository->getByEmail($google_user->email);
        //register 
        if (!$user) {
            $attributes = [
                'name' => $google_user->name,
                'google_id' => $google_user->id,
                'email' => $google_user->email,
                'email_verified_at' => Carbon::now(),
            ];
        } else {
            if($user->google_id === null) {
                $user->google_id = $google_user->id;
                if($user->email_verified_at === null) {
                    $user->email_verified_at = Carbon::now();
                }
                $user->save();
            }
        }

        $token = $user->createToken(config('app.name'), ['server:update']);

        $url = config('selfdriveph.frontend_url') . 'api/login/google/?token=' . $token->plainTextToken . '&user=' . $user;
        return Redirect::to($url);
    }

    public function profile()
    {
        $user = Auth::user();
        return $this->responseService->resolveResponse(__('Auth User'), $user);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->responseService->resolveResponse("Logout Successful", null);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $result = $this->modelService->forgotPassword($request->email);
        return $this->responseService->resolveResponse("An email has been sent to your email address with instructions on how to reset your password.", $result);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->modelService->resetPassword($request->token, $request->password);
        return $this->responseService->resolveResponse("Your password has been updated successfully!", $result);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $result = $this->modelService->updateProfile($request->all());
        return $this->responseService->resolveResponse("Your profile has been updated successfully!", $result);
    }

}

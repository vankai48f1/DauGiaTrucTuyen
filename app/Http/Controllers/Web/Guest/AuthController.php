<?php

namespace App\Http\Controllers\Web\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\{LoginRequest, NewPasswordRequest, PasswordResetRequest, RegisterRequest};
use App\Models\Core\User;
use App\Services\Core\{AuthService, UserService, VerificationService};
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function loginForm(): View
    {
        return view('core.no_header_pages.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $response = $this->service->login($request);

        if (Auth::check()) {
            return redirect()->route(REDIRECT_ROUTE_TO_USER_AFTER_LOGIN)->with($response[RESPONSE_STATUS_KEY], $response[RESPONSE_MESSAGE_KEY]);
        }

        return redirect()->back()->with($response[RESPONSE_STATUS_KEY], $response[RESPONSE_MESSAGE_KEY]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }

    public function register(): View
    {
        return view('core.no_header_pages.register');
    }

    public function storeUser(RegisterRequest $request): RedirectResponse
    {
        $parameters = $request->only(['first_name', 'last_name', 'email', 'username', 'password']);

        if ($user = app(UserService::class)->generate($parameters)) {
            app(VerificationService::class)->_sendEmailVerificationLink($user);
            return redirect()->route('login')->with(RESPONSE_TYPE_SUCCESS, __('Registration successful. Please check your email to verify your account.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Registration failed. Please try after sometime.'));
    }


    public function forgetPassword(): View
    {
        return view('core.no_header_pages.forget_password');
    }

    public function sendPasswordResetMail(PasswordResetRequest $request): RedirectResponse
    {
        $response = $this->service->sendPasswordResetMail($request);
        $status = $response[RESPONSE_STATUS_KEY] ? RESPONSE_TYPE_SUCCESS : RESPONSE_TYPE_ERROR;

        return redirect()->route('forget-password.index')->with($status, $response[RESPONSE_MESSAGE_KEY]);
    }

    public function resetPassword(Request $request, User $user): View
    {
        $data = $this->service->resetPassword($request, $user->id);

        return view('core.no_header_pages.reset_password', $data);
    }

    public function updatePassword(NewPasswordRequest $request, User $user): RedirectResponse
    {
        $response = $this->service->updatePassword($request, $user);
        $status = $response[RESPONSE_STATUS_KEY] ? RESPONSE_TYPE_SUCCESS : RESPONSE_TYPE_ERROR;

        return redirect()->route('login')->with($status, $response[RESPONSE_MESSAGE_KEY]);
    }
}

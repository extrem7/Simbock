<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Frontend\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Route2Class;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        logout as parentLogout;
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $this->seo()->setTitle('Login');

        Route2Class::addClass('bg-decorative');

        return view('frontend::auth.login');
    }

    public function redirectPath(): string
    {
        return '/';
    }

    protected function sendLoginResponse(Request $request): JsonResponse
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return response()->json(['redirect' => $this->redirectPath()]);
    }

    protected function sendFailedLoginResponse(Request $request): void
    {
        $message = trans('auth.failed');

        if (($user = User::whereEmail($request->input('email'))->first()) && !$user->has_password) {
            $message = trans('auth.no_password');
        }

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }

    public function logout(Request $request): Response
    {
        $this->parentLogout($request);

        return new Response('', 204);
    }
}

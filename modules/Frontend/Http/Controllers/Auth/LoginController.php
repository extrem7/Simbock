<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Modules\Frontend\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $this->seo()->setTitle('Login');

        \Route2Class::addClass('bg-decorative');

        return view('frontend::auth.login');
    }

    public function redirectPath()
    {
        return '/asd1';
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return response()->json(['redirect' => $this->redirectPath()]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $message = trans('auth.failed');

        if ($user = User::whereEmail($request->input('email'))->first()) {
            if (!$user->has_password) $message = trans('auth.no_password');
        }

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }
}

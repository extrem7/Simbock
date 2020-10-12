<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Frontend\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token = null)
    {
        $this->seo()->setTitle('Password Reset');

        \Route2Class::addClass('bg-decorative');

        share([
            'email' => $request->email,
            'token' => $token
        ]);

        return view('frontend::auth.passwords.reset');
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json([
            'message' => trans($response),
            'redirect' => route('frontend.home')
        ]);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        throw ValidationException::withMessages(['email' => [trans($response)]]);
    }
}

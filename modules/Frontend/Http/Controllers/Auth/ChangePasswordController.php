<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Route2Class;

class ChangePasswordController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function form()
    {
        $this->seo()->setTitle('Change Password');

        Route2Class::addClass('bg-decorative');

        return view('frontend::auth.passwords.change', [
            'email' => Auth::getUser()->email
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::getUser()->password)) $fail('Current password in incorrect.');
            }],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        Auth::getUser()->update(['password' => Hash::make($request->password)]);

        return response()->json(['message' => 'Password has been changed.']);
    }
}

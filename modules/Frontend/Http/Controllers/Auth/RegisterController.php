<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Modules\Frontend\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $this->seo()->setTitle('Register');

        \Route2Class::addClass('bg-decorative');

        return view('frontend::auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $this->validator($data)->validate();

        event(new Registered($user = $this->create($data)));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return response()->json(['redirect' => $this->redirectPath()]);
    }

    public function redirectPath()
    {
        return '/';
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_volunteer' => ['required', 'boolean']
            //recaptchaFieldName() => recaptchaRuleName()
        ]);
    }

    protected function create(array $data): User
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['is_volunteer'] ? User::VOLUNTEER : User::COMPANY
        ]);

        return $user;
    }
}

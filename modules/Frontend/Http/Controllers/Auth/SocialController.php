<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Modules\Frontend\Http\Controllers\Controller;
use App\Models\User;

class SocialController extends Controller
{
    private User $user;

    public function redirect(string $provider, bool $isCompany = false)
    {
        $driver = \Socialite::driver($provider);

        if ($isCompany)
            return $driver
                ->with(['redirect_uri' => url("/social/company/$provider/callback")])
                ->redirect();

        return $driver->redirect();
    }

    public function callback(string $provider, bool $isCompany = false)
    {
        $userSocial = \Socialite::driver($provider)->stateless()->user();

        $registered = User::where(['email' => $userSocial->getEmail()])
            ->orWhere(['provider_id' => $userSocial->getId()])
            ->first();

        if ($registered) {
            \Auth::login($registered);
            return redirect()->route('frontend.home');
        } else {
            $this->user = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider
            ]);

            if ($avatar = $userSocial->getAvatar()) {
                $this->user->addMediaFromUrl($avatar)->toMediaCollection('avatar');
            }

            \Auth::login($this->user);
            return redirect()->route('frontend.home');
        }
    }

    public function companyRedirect(string $provider)
    {
        return $this->redirect($provider, true);
    }

    public function companyCallback(string $provider)
    {
        return $this->callback($provider, true);
    }
}

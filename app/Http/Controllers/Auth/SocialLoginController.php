<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if (! $user) {
            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'first_name' => $socialUser->getName() ?: $socialUser->getNickname(),
                    'surname' => '',
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'customer',
                    'dark_mode' => false,
                ]
            );

            $user->provider = $provider;
            $user->provider_id = $socialUser->getId();
            $user->save();
        }

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}

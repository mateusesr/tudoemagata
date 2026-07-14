<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $socialAccount = SocialAccount::where('provider', 'google')
            ->where('provider_id', $googleUser->getId())
            ->first();

        if ($socialAccount) {
            Auth::login($socialAccount->user);

            return redirect()->intended(route('dashboard'));
        }

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => Str::password(32),
                'email_verified_at' => now(),
            ]
        );

        $user->socialAccounts()->create([
            'provider' => 'google',
            'provider_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);

        $user->customer()->firstOrCreate([], ['customer_type' => 'retail']);

        Auth::login($user);

        return redirect()->intended(route('dashboard'));
    }
}

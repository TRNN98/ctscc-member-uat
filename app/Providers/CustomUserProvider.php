<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider extends UserProvider
{
    /**
     * Overrides the framework defaults validate credentials method
     *
     * @param UserContract $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $envsecret = config('auth.SECRET_AUTH');

        $plain = $credentials['password'];
        $plain = hash_hmac('sha256', $plain, $envsecret);

        return $plain === $user->getAuthPassword() ? true : false;
    }
}

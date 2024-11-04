<?php

namespace App\Foundation\Auth;

use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class EloquentUserProvider implements UserProvider
{
   
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    // public function validateCredentials(UserContract $user, array $credentials)
    // {
    //     $plain = $credentials['password'];
    //     dd($plain);
    //     // return md5($plain);
    //     return md5($plain)===$user->getAuthPassword()?true:false;
    //     // return $this->hasher->check($plain, $user->getAuthPassword());
    // }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        $envsecret = config('auth.SECRET_AUTH');

        $plain = $credentials['password'];
        $plain = hash_hmac('sha256',$plain,$envsecret);

        return $plain===$user->getAuthPassword() ? true: false;
    }
}

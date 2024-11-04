<?php

namespace App\Http\Controllers\Member\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait
{
    public function issueToken(Request $request, $grantType, $scope = "")
    {
        $params = [
            'grant_type' => $grantType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => $scope
        ];

        // if ($grantType !== 'social') {
        //     $params['username'] = $request->username ?: $request->email;
        //     $params['password'] = $request->password;
        // }
        $params['username'] = $request->membership_no;
        $params['password'] = $request->mem_password;
        $params['refresh_token'] = $request->refresh_token;

        $request->request->add($params);
        // dd($request->all());

        // $proxy = Request::create('/api/v2/oauth/token', 'POST');

        $proxy = $request->create('/api/v2/oauth/token', 'POST', $params);

        $result = app()->handle($proxy);

        return $result;
    }

    public function destroyToken(Request $request, $token)
    {
        $params = [
            'token_id' => $token,
        ];

        // if ($grantType !== 'social') {
        //     $params['username'] = $request->username ?: $request->email;
        //     $params['password'] = $request->password;
        // }

        $request->request->add($params);
        // dd($request->all());

        $proxy = Request::create('/api/v2/oauth/token', 'DELETE');

        return Route::dispatch($proxy);
    }
}

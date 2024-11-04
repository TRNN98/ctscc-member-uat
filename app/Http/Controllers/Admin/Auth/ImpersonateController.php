<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\member\api\Member;
use App\Model\member\SmMemMembershipRegistered;
use Illuminate\Support\Facades\Auth;
// use Tymon\JWTAuth\Facades\JWTAuth;

class ImpersonateController extends Controller
{
    public function index($membership_no)
    {
        try {
            $token = Auth::guard('api')->getToken()->get();
            if ($token) {
                Auth::guard('api')->invalidate($token);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        session()->forget('impersonate');
        session()->forget('membership_no');

        $user = Member::where('membership_no', $membership_no)->first();

        if ($user) {
            session()->put('impersonate', $user);
            session()->put('membership_no', $membership_no);
        }

        return redirect('/impersonate');
    }

    public function destroy()
    {
        session()->forget('impersonate');
        session()->forget('membership_no');

        return redirect('/home');
    }

    public function auth_member()
    {
        $token = Auth::guard('api')->getToken()->get();

        session()->forget('impersonate');

        return $this->respondWithToken($token);
    }

    // Jwt Web member
    protected function respondWithToken($token)
    {
        $membership_no = Auth::guard('api')->user()->membership_no;
        $user = SmMemMembershipRegistered::find($membership_no);

        return response()->json([
            'token' => $token,
            'member' => $user,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}

<?php

namespace App\Http\Controllers\Info\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Api_info_AuthController extends Controller
{
    public function is_admin()
    {
        if (Auth::guard('admin')->check()) {
            $is_admin = true;

        }else{
            $is_admin = false;
        }
        return response()->json(compact('is_admin'));
    }
}

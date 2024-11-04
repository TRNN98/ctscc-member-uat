<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Ws_change_passwordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('admin.part.ws_change_password');
    }

    public function changepassnewpassword(Request $request)
    {
        // dd(Auth::user()->username);
        $admin = Auth::user();
        $envsecret = config('auth.SECRET_AUTH');
        $chk_oldpass = DB::table('www_security_user')->where('username','=',Auth::user()->username)->pluck('password')->first();

        if(hash_hmac('sha256',$request->old_password,$envsecret) == $chk_oldpass)
        {

            $admin->password = hash_hmac('sha256',$request->new_password,$envsecret);
            $admin->password_sha = hash_hmac('sha256',$request->new_password,$envsecret);
            $admin->save();
            // echo '<script>alert("เปลี่ยนรหัสผ่านเรียบร้อยแล้ว"); window.history.back();</script>';
            return redirect()->back()->with('message',"เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");

        }else{
        
            return redirect()->back()->with('danger','รหัสผ่านเดิม ไม่ถูกต้อง !');

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

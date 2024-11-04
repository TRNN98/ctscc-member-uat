<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Ws_constantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataconstant = DB::table('www_constant')->first();
        //dd($dataconstant);
        return view('admin.part.ws_constant',compact('dataconstant'));
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
        //dd($request->all());
        $updateconstant = DB::table('www_constant')->update([
                                                        'coop_name' => $request->tf_cname , 
                                                        'identified_type' => $request->tf_login_method,
                                                        'change_pwd_box' => $request->lm_chpass,
                                                        'mem_gain_detail' => $request->lm_gain,
                                                        'mem_receive_dividend' =>$request->lm_divid ,
                                                        // softlaunch
                                                        'member_maintenance' => $request->member_maintenance,
                                                        'www_followme_softlaunch' => $request->www_followme_softlaunch,
                                                        'www_promoney_softlaunch' => $request->www_promoney_softlaunch,
                                                    ]);

        return redirect()->back()->with('message','อัพเดทข้อมูลสำเร็จ');
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

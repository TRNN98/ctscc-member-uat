<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ws_approve_divindedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('www_kep_divinded_controller')
            ->orderBy('account_year', 'desc')
            ->where('account_year', '>', '2010')
            ->get();
        // dd($data);
        return view('admin.part.ws_approve_divinded', ['data' => $data]);
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
        // dd($request->all(), $id);
        $newStatus = $request->newconf;

        $update = DB::update(
            'UPDATE www_kep_divinded_controller
                                SET approve_status = :newstatus,
                                updated_date=:updated_date
                                where account_year = :account_year',
            ['newstatus' => $newStatus, 'account_year' => $id, 'updated_date' => DATETIME]
        );

        if ($update) {
            return redirect()->back()->with('message', 'อัพเดทสำเร็จ');
        } else {
            return redirect()->back()->with('danger', 'ไม่อัพเดทได้ กรุณาลองใหม่อีกครั้ง');
        }
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
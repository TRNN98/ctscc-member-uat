<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\admin;
use Illuminate\Support\Facades\DB;

class Ws_user_controlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_user_group = DB::table('www_ucf_user_group')->get();

        $list_user = DB::table('www_security_user')
            ->select('www_security_user.seq', 'www_security_user.username', 'www_security_user.description', 'www_ucf_user_group.group_code', 'www_ucf_user_group.group_name', 'www_ucf_user_group.group_description')
            ->join('www_ucf_user_group', 'www_security_user.group_code', '=', 'www_ucf_user_group.group_code')
            ->get();

        // dd($list_user);
        return view('admin.part.ws_user_control', compact('list_user', 'list_user_group'));
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
        if (isset($request->btn_add_user)) {

            $envsecret = config('auth.SECRET_AUTH');

            $admin = new admin();

            $admin->username = $request->tf_add_user_name;
            $admin->password = hash_hmac('sha256', $request->tf_add_user_passwd, $envsecret);
            $admin->description = $request->tf_description;
            $admin->level_code = $request->lm_ucf_group;
            $admin->group_code = $request->lm_ucf_group;
            $admin->password_sha = hash_hmac('sha256', $request->tf_add_user_passwd, $envsecret);

            $admin->save();
            // admin::create([
            //     [
            //         'username' => $request->tf_add_user_name,
            //         'password' => hash_hmac('sha256',$request->tf_add_user_passwd,$envsecret),
            //         'description' => $request->tf_description,
            //         'level_code' => $request->lm_ucf_group,
            //         'group_code' => $request->lm_ucf_group,
            //         'password_sha' => hash_hmac('sha256',$request->tf_add_user_passwd,$envsecret),

            //     ]
            // ]);

        }

        if (isset($request->btn_add_group)) {

            if (empty($request->add_group_des)) {
                $request->add_group_des = null;
            }

            $insert_user = DB::table('www_ucf_user_group')->insert([
                [
                    'group_code' => $request->tf_add_group_no,
                    'group_name' => $request->add_group_name,
                    'group_description' => $request->add_group_des
                ]
            ]);
        }

        return redirect()->back()->with('message', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function deletedata(Request $request)
    {
        if ($request->tablename == 'www_security_user') {
            $admin = admin::find($request->pk);
            $res = $admin->delete();
        } else {
            $res = DB::table($request->tablename)->where($request->fieldname, $request->pk)->delete();
        }

        if (!$res) {
            return response()->json(['rccode' => 0], 500);
        }
        return response()->json(['rccode' => 1], 200);
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

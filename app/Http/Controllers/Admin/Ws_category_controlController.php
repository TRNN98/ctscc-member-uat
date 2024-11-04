<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\www_data;
use App\Model\admin\www_ucf_category;

class Ws_category_controlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $datafetch = www_ucf_category::orderBy('type', 'asc')->get();

        return view('admin.part.ws_category_control', compact('datafetch'));
    }

    public function updatecategory(Request $request)
    {
        www_ucf_category::find($request->pk)->update([$request->name => $request->value]);

        return response()->json(['success' => 'done']);
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
        $Category = new www_ucf_category();

        $Category->category = $request->addcategory;
        $Category->description = $request->adddescription;
        $Category->hyper_link = $request->addhyperlink;
        $Category->type = $request->addtype;
        $Category->content_type = $request->addcontenttype;

        $insertCategory = $Category->save();

        if ($insertCategory) {
            return redirect()->back()->with('message', 'เพิ่มข้อมูลสำเร็จ');
        } else {
            return redirect()->back()->with('danger', 'เพิ่มข้อมูลไม่สำเร็จ');
        }
    }

    public function deletedata(Request $request)
    {
        $deletecategory = www_ucf_category::find($request->id)->delete();
        return response()->json(['success' => 'done']);
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
    }
}

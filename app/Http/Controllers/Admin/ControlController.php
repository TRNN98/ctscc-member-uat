<?php

namespace App\Http\Controllers\Admin;

use App\Model\admin\www_ucf_category as Control;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\www_ucf_manu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
// use DB;

class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // return redirect('admin/control/home/home/A');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        if (!isset($request->type)) {
            $type = Control::where('type', 'A')->where('status', 1)->orderBy('description', 'ASC')->get();
            // $gtype = "A";
        } else {
            $gtype = $request->type;
            if ($gtype == 'M') {

                //ไม่ให้แสดงเมนู ใด ในแท็ป sidebar บ้าง (type=M)
                $WhereNot = array(
                    20, //<== สมาคมฌาปนกิจ
                );

                $menus = www_ucf_manu::where('status', '=', '1')
                    ->where('is_parent', '=', '1')
                    ->whereNotIn('seq',$WhereNot)
                    ->get();
                    
                foreach ($menus as $key => $menu) {
                    $submenuIn[$key] = DB::table('www_ucf_sub_manu')
                        ->join('www_ucf_category', 'www_ucf_sub_manu.cat_id', '=', 'www_ucf_category.seq')
                        ->where('www_ucf_sub_manu.status', '=', '1')
                        ->where('www_ucf_category.status', '=', '1')
                        ->where('www_ucf_category.type', $gtype)
                        ->where('www_ucf_sub_manu.manu_id', '=', $menu->seq)
                        ->orderBy('www_ucf_category.description', 'ASC')->get();
                }

                $submenuOut = DB::table('www_ucf_category')
                    ->whereNotIn('seq', function ($query) {
                        $query->select('cat_id')->from('www_ucf_sub_manu')
                            ->where('status', '=', '1');
                    })
                    ->where('www_ucf_category.type', $gtype)
                    ->where('www_ucf_category.status', '=', '1')
                    ->orderBy('www_ucf_category.description', 'ASC')->get();


                $type = [$menus, $submenuIn, $submenuOut];
            } else {
                
                // เมนูย่อยในแท็ปที่ 2 (ประกาศข้องสหกรณ์,รายงานกิจการประจำปี,รายงานการตรวจสอบบัญชี)
                // เมนูย่อยในแท็ปที่ 3 (ระเบียบ63,ระเบียบสมาชิก,ระเบียบเงินกู้,ระเบียบเงินฝาก,ระเบียบสวัสดิการ,ระเบียบการทำงาน)
                // 1.ไม่ให้แสดงใน sidebar ให้ไปแสดงเป็นเมนูย่อย ในหัวเมนูหลัก => ข่าวสารต่างๆ แทน
                // 2.ไม่ให้แสดงใน sidebar ให้ไปแสดงเป็นเมนูย่อย ในหัวเมนูหลัก => ระเบียบ/ข้อบังคับของสหกรณ์ แทน
                    
                    $submenuInTab = array(
                        //- Tab ข่าวสารต่างๆ
                        'news_activity',
                        'cremation_news',
                        'news_purchase',
                        'news_substance',
                        // - Tab ระเบียบ
                        'procedure',
                        'procedure_loan',
                        'procedure_deposit',
                        'procedure_member',
                        'procedure_welfare',
                        'procedure_work',
                        'rules'
                    );

                // ============================================

                $type = Control::where('type', $gtype)
                    ->where('status', 1)
                    ->whereNotIn('category', $submenuInTab) //<==== ไม่ให้แสดงเมนูใน sidebar
                    ->orderBy('description', 'ASC')->get();
            }
        }

        // dd($type);

        $group_code = DB::table('www_security_user')->where('username', Auth::user()->username)->pluck('group_code');
        //dd($group_code[0]);
        $numberDesc = array(
            "A" => "หน้าหลัก Admin",
            "C" => "เนื้อหาหน้าแรก",
            "G" => "เนื้อหาประเภทรูปภาพ",
            "M" => "เนื้อหาภายในเมนู",
            "L" => "สมาคมฌาปนกิจ",
            "O" => "Mobile App",
            "S" => "SuperUser!"
        );

        // if (!in_array($group_code[0], array('S', 'A'))) {
        //$head_menu = Control::select('type')->distinct()->whereNotIn('type',['L','S','C','M','H'])->orderBy('type' , 'ASC')->get();
        // }

        if (in_array($group_code[0], array('A'))) {
            $head_menu = Control::select('type')->distinct()->whereNotIn('type', ['S', 'H'])->orderBy('type', 'ASC')->get();

            $typeMobile = Control::where('status', 1)->orderBy('description', 'ASC')->get();
            $list_type = [];
            foreach ($typeMobile as $key => $item) {
                $list_type[$item->type] = Control::where('type', $item->type)->where('status', 1)->orderBy('description', 'ASC')->get();
            }
        }
        if ($group_code[0] == 'S') {
            $head_menu = Control::select('type')->distinct()->orderBy('type', 'ASC')->get();

            $typeMobile = Control::where('status', 1)->orderBy('description', 'ASC')->get();
            $list_type = [];
            foreach ($typeMobile as $key => $item) {
                $list_type[$item->type] = Control::where('type', $item->type)->where('status', 1)->orderBy('description', 'ASC')->get();
            }
        }

        return view('admin.home', ['gtype' => $type, 'head_menu' => $head_menu, 'numberDesc' => $numberDesc, 'list_type' => $list_type]);
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

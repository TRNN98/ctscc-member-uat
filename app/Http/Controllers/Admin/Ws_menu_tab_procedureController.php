<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\admin\www_ucf_category;
use Illuminate\Http\Request;

class Ws_menu_tab_procedureController extends Controller
{
    public function index()
    {
        // ไม่ให้แสดงใน sidebar ให้ไปแสดงเป็นเมนูย่อย ในหัวเมนูหลัก => ระเบียบ/ข้อบังคับของสหกรณ์ แทน
        $submenuInTab3 = array(
            'procedure',
            'procedure_loan',
            'procedure_deposit',
            'procedure_member',
            'procedure_welfare',
            'procedure_work',
            'rules'
        );

        $menuTab3 = www_ucf_category::whereIn('Category', $submenuInTab3)->get();

        return  view('admin.part.ws_menu_tab_procedure',compact('menuTab3'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\admin\www_ucf_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ws_menu_tab_news_etcController extends Controller
{
    public function index()
    {
        // ไม่ให้แสดงใน sidebar ให้ไปแสดงเป็นเมนูย่อย ในหัวเมนูหลัก => ข่าวสารต่างๆ แทน
        $submenuInTab2 = array(
            'pic_activity',
            'cremation_news',
            'news_purchase',
            'news_substance'
        );

        $menuTab2 = www_ucf_category::whereIn('Category', $submenuInTab2)->get();

        return view('admin.part.ws_menu_tab_news_etc', compact('menuTab2'));
    }
}

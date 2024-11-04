<?php

namespace App\Http\Controllers\Info\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\admin\www_data;
use App\Model\admin\www_data_img;
use App\Model\admin\www_ucf_category;
use Illuminate\Support\Facades\Session;

// use DB;
// use View;

class Api_info_ShowController extends Controller
{
    public function show($id)
    {
        $blogKey = 'blog_' . $id;

        $data = Session::all();

        $show = www_data::find($id);

        if (!Session::has($blogKey)) {
            $show->disableLogging();
            $show->pageview = $show->pageview + 1;
            $show->save();
            Session::put($blogKey, 1);
        }

        $news_last = www_data::where('Category', 'news_relations')->orderBy('Date', 'desc')->limit(5)->get();

        $gtype = www_ucf_category::where('category', $show->Category)->pluck('type')->first();

        $types = www_ucf_category::where('category', $show->Category)->pluck('description')->first();

        if ($gtype == "G") {
            $pic_activity = www_data_img::where('No', $show->No)->get();
        } else {
            $pic_activity = null;
        }

        return response()->json(compact('show', 'gtype', 'types', 'news_last', 'pic_activity'));
    }
}

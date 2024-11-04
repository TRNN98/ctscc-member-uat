<?php

namespace App\Http\Controllers\Info\Api;

use App\Http\Controllers\Controller;
use App\Model\admin\www_data;
use Illuminate\Http\Request;
// use App\Model\admin\www_data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

// use View;

class Api_info_ListController extends Controller
{
    public function list($Category, Request $request)
    {
        $gtype = DB::table('www_ucf_category')->where('category', $Category)->pluck('type')->first();
        $content_type = DB::table('www_ucf_category')->where('category', $Category)->pluck('content_type')->first();
        $download = DB::table('www_ucf_category')->where('category', $Category)->pluck('category')->first();

        $types = DB::table('www_ucf_category')->where('category', $Category)->pluck('description')->first();

        if ($Category == "all") {
            $list_data = DB::table('www_data')->orderBy('DataSort', 'asc')->paginate(6);
            $types = "ทั้งหมด";
        } else if ($content_type == 'calender') {
            $list_data = DB::table('www_data')->where('Category', $Category)->orderBy('DataSort', 'asc')->get();
            $news_last = null;
        } else if ($content_type == 'photo') {
            $list_data = DB::table('www_data')->where('Category', $Category)->orderBy('DataSort', 'asc')->paginate(6);
            $news_last = null;
        } else if ($content_type == 'personnel') {
            $list_data = [
                'data' => DB::table('www_data')->where('Category', $Category)->orderBy('DataSort', 'asc')->get()
            ];
            $news_last = DB::table('www_data')->where('Category', 'news_relations')->orderBy('DataSort', 'asc')->limit(5)->get();
        } else if ($download == 'download') {
            $list_data = DB::table('www_data')->where('Category', $Category)->orderBy('DataSort', 'asc')->get();
            $news_last = DB::table('www_data')->where('Category', 'news_relations')->orderBy('DataSort', 'asc')->limit(5)->get();
        } else {
            $list_data = DB::table('www_data')->where('Category', $Category)->orderBy('DataSort', 'asc')->paginate(6);
            $news_last = DB::table('www_data')->where('Category', 'news_relations')->orderBy('DataSort', 'asc')->limit(5)->get();
        }

        return response()->json(compact('list_data', 'types', 'news_last', 'gtype', 'content_type'));
    }

    public function search(Request $request)
    {
        if ($request->type == 'search') {
            $news_last = DB::table('www_data')->where('Category', 'news_relations')->orderBy('DataSort', 'asc')->limit(5)->get();

            $list_data = DB::table('www_data')
                ->join('www_ucf_category', 'www_data.Category', '=', 'www_ucf_category.category')
                ->where('www_data.Question', 'like', "%$request->search%")
                ->where('www_ucf_category.status', '=', "1")
                ->whereNotIn('www_data.Category', ['panel', 'employee', 'banner', 'contact'])
                ->orderBy('www_data.DataSort', 'asc')->paginate(6);

            $types = "การค้นหา";
        }

        return response()->json(compact('list_data', 'types', 'news_last'));
    }

    public function download(Request $request)
    {
        $gtype = DB::table('www_ucf_category')->where('category', 'download')->pluck('type')->first();
        $content_type = DB::table('www_ucf_category')->where('category', 'download')->pluck('content_type')->first();
        $types = DB::table('www_ucf_category')->where('category', 'download')->pluck('description')->first();

        $list_data = [
            'data' => DB::table('www_data')->where('Category', 'download')->orderBy('DataSort', 'asc')->get()
        ];
        $news_last = DB::table('www_data')->where('Category', 'news_relations')->orderBy('DataSort', 'asc')->limit(5)->get();

        return response()->json(compact('list_data', 'types', 'news_last', 'gtype', 'content_type'));
    }
}

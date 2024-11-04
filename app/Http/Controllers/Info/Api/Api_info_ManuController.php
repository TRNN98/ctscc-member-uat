<?php

namespace App\Http\Controllers\Info\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Api_info_ManuController extends Controller
{
    public function manu()
    {
        $list_manu = DB::table('www_ucf_manu')
                        ->where('status', '=', '1')
                        ->get();

        $list_sub_manu = DB::table('www_ucf_sub_manu')
                            ->select('www_ucf_manu.manu_name' , 'www_ucf_manu.is_parent' , 'www_ucf_sub_manu.*' ,'www_ucf_category.description')
                            ->join('www_ucf_manu','www_ucf_sub_manu.manu_id', '=' ,'www_ucf_manu.seq')
                            ->join('www_ucf_category','www_ucf_sub_manu.cat_id', '=' ,'www_ucf_category.seq')
                            ->where('www_ucf_manu.status', '=', '1')
                            ->where('www_ucf_sub_manu.status', '=', '1')
                            ->where('www_ucf_category.status', '=', '1')
                            ->orderBy('www_ucf_sub_manu.seq','desc')
                            ->get();
                            
        return response()->json(compact('list_manu','list_sub_manu'));
    }
}

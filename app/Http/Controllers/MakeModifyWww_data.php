<?php

namespace App\Http\Controllers;

use App\Model\admin\www_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MakeModifyWww_data extends Controller
{
    //
    // -------------------------------------------ปอม--------------------------------------------------------------------------
    // php artisan tinker
        // $pom = app()->make('App\Http\Controllers\MakeModifyWww_data');

        // $data = app()->call([$pom,'index'],[]);

        // app()->call([$pom,'Matching'],[$data]);
    // ---------------------------------------------------------------------------------------------------------------------

    public function index()
    {
        $data = www_data::get();

        return $data;
    }

    public function Matching_www_data($user)
    {
        $pom = [];

        foreach($user as $datas)
        {
            $www_data = www_data::where('No',$datas->No)->first();

            $pom[] = $www_data->No;
            $www_data->Note = $this->switch_new_path($www_data->Note);
            $www_data->save();

        }
        // ส่งกลับ
        return $pom;
    }


    public function switch_new_path($note)
    {
        $pattern = "/\/coop\/ckeditor\/system\/plugins\/ckfinder\/upload\//i";
        $result = preg_replace($pattern,"../mediafiles/",$note);
        return $result;
    }


    public function Update_path_dataFile()
    {
        $user = $this->index();
        $da = [];
        // dd($user);
        foreach($user as $datas)
        {
            $www_data = www_data::where('No',$datas->No)->first();

            $da[] = $www_data->No;
            $www_data->ndata = $this->switch_new_pathFile($www_data->ndata);
            $www_data->save();

        }
        // ส่งกลับ
        return $da;
    }
    
    public function switch_new_pathFile($note)
    {
        $pattern = str_replace(' ','_',$note);
        $result = $pattern;
        return $result;
    }
}

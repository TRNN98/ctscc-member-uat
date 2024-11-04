<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\www_data;
use App\Model\admin\www_data_img;
use App\Model\admin\www_ucf_category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Response;

class Ws_post_editController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $_SELECTED = Request('Category');
        $type = Request('type');
        // $Category = Request('Category');

        $json_dataimg = json_encode(www_data_img::where('No', Request('No'))->get());

        $Category = www_ucf_category::where('category', Request('Category'))->first();

        if (Request('Category')) {
            $description = DB::select('SELECT *  FROM www_ucf_category WHERE type = :type ORDER BY description ASC', ['type' => $type]);
            // dd($json_dataimg );

        } else {
            $description = DB::select('SELECT *  FROM www_ucf_category WHERE type = :type ORDER BY description ASC', ['type' => $type]);
        }
        $www_data = www_data::where('No', Request('No'))->first();
        // return $www_data;

        return view('admin.part.ws_post_edit', [
            'table' => $www_data, 'selected' => $_SELECTED, 'category' => $Category, 'description' => $description, 'json_dataimg' => $json_dataimg
        ]);
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
        // dd($request->all());
        $www_data = www_data::find($id);

        if (isset($request->Submit) && $request->lm_ucf_category != "") {

            $Question = $request->QTitle;
            $Name = $request->QName;

            if (strpos($Question, '<script>') !== false || strpos($Question, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            if (strpos($Name, '<script>') !== false || strpos($Name, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            // if ($request->hasFile('pic_upload')) {
            //     if( preg_replace('/[^ก-ฮ]/u','',$request->pic_upload->getClientOriginalName()) )
            //     {
            //         // $typePic = explode('.',$request->pic_upload->getClientOriginalName());
            //         $ext = pathinfo($request->pic_upload->getClientOriginalName(), PATHINFO_EXTENSION);
            //         $randname = rand();
            //         $imageName = $randname.'.'.$ext;
            //     }else{
            //         $imageName = $request->pic_upload->getClientOriginalName();
            //     }
            //     $request->pic_upload->move('mediafiles/picture',$imageName);

            // }else{
            //     if ($request->show_pic_upload == null) {
            //         unlink('mediafiles/picture/' . $request->hf_pic_upload);
            //         $imageName = null;
            //     }else{
            //         $imageName = $request->hf_pic_upload;
            //     }
            // }

            // if ($request->hasFile('file_upload')) {
            //     if( preg_replace('/[^ก-ฮ]/u','',$request->file_upload->getClientOriginalName()) )
            //     {
            //         // $typePic = explode('.',$request->file_upload->getClientOriginalName());
            //         $ext = pathinfo($request->file_upload->getClientOriginalName(), PATHINFO_EXTENSION);
            //         $randname = rand();
            //         $fileName = $randname.'.'.$ext;
            //     }else{
            //         $fileName = $request->file_upload->getClientOriginalName();
            //     }
            //     $request->file_upload->move('mediafiles/data',$fileName);
            //     // $fileName = $request->file_upload->getClientOriginalName();
            //     // $request->file_upload->move('mediafiles/data',$fileName);
            // }else{
            //     if ($request->show_file_upload == null) {
            //         unlink('mediafiles/data/' . $request->hf_file_upload);
            //         $fileName = null;
            //     }else{
            //         $fileName = $request->hf_file_upload;
            //     }
            //     // $fileName = $request->hf_file_upload;
            // }

            $Category = $request->lm_ucf_category;
            $IP = f_get_ip();

            // $www_data = new www_data;
            $www_data->Category = $Category;
            $www_data->Question = $request->QTitle;
            $www_data->Note = empty($request->QNote) ? (empty($request->QNote1) ? "" : $request->QNote1 . '<br><br>' . $request->QNote2 . '<br><br>' . $request->QNote3) : $request->QNote;
            $www_data->Name = $request->QName;
            // $www_data->Namer = $request->body;
            $www_data->IP = $IP;
            $www_data->ReplayDate = empty($request->ReplayDate) ? null : $request->ReplayDate;
            // $www_data->Email = $request->status;
            $www_data->Date = DATETIME;
            // if ($www_data->nphoto != $imageName) {
            //     File::delete(PHOTO_PATH.$www_data->nphoto);
            //     $www_data->nphoto = $imageName;
            // }
            // if ($www_data->ndata != $fileName) {
            //     File::delete(FILE_PATH.$www_data->ndata);
            //     $www_data->ndata = $fileName;
            // }
            $www_data->nphoto = $request->show_pic_upload;
            $www_data->ndata = empty($request->show_file_upload) ? $request->show_file_upload2 : $request->show_file_upload;
            // $www_data->nlink = empty($request->show_file_upload2) 
            //                     ? '' 
            //                     : (!empty($request->show_file_upload) 
            //                         ? '' 
            //                         : 'uselink');
                                    
            $www_data->nmedia = $request->nmedia;

            $www_data->save();

            if (count($request->photos) > 0) {
                //    dd($request->all());

                for ($i = 0; $i < count($request->photos); $i++) {

                    if (preg_replace('/[^ก-ฮ]/u', '', $request->photos[$i]->getClientOriginalName())) {
                        // $typePic = explode('.',$request->photos[$i]->getClientOriginalName());
                        $Nameext = pathinfo($request->photos[$i]->getClientOriginalName(), PATHINFO_FILENAME);
                        $ext = pathinfo($request->photos[$i]->getClientOriginalName(), PATHINFO_EXTENSION);

                        $randname = rand();
                        $newname = $randname . '.' . $ext;

                        $www_data_img = new www_data_img;
                        $www_data_img->No = $www_data->No;
                        $www_data_img->path_img = $newname;
                        $www_data_img->save();

                        $request->photos[$i]->move('mediafiles/pic_activity', $newname);
                    } else {

                        $Nameext = pathinfo($request->photos[$i]->getClientOriginalName(), PATHINFO_FILENAME);
                        $ext = pathinfo($request->photos[$i]->getClientOriginalName(), PATHINFO_EXTENSION);

                        $newname = $Nameext . '.' . $ext;
                        // dd($newname[$i]);
                        $www_data_img = new www_data_img;
                        $www_data_img->No = $www_data->No;
                        $www_data_img->path_img = $Nameext . '.' . $ext;
                        $www_data_img->save();

                        $request->photos[$i]->move('mediafiles/pic_activity', $Nameext . '.' . $ext);
                    }
                }
                // for( $i=0; $i < count($request->photos);$i++)
                // {

                // if($request->photos[$i] != null)
                // {
                // dd($request->photos[$i]);

                // if( preg_replace('/[^ก-ฮ]/u','',$request->photos[$i]->getClientOriginalName()) )
                // {
                //     $typePic = explode('.',$request->photos[$i]->getClientOriginalName());
                //     $filename = pathinfo($request->photos[$i], PATHINFO_FILENAME);
                //     dd($request->photos,$typePic);
                //     $randname = rand();
                //     $newname = (string)$randname.'.'.$typePic[1];
                //     //dd('ไฟล์มีภาษาไทย',$filename, $request->photos[$i]->getClientOriginalExtension());
                //     $www_data_img = new www_data_img;

                //     $www_data_img->No = $www_data->No;
                //     $www_data_img->path_img = $newname;
                //     $www_data_img->save();

                //     $request->photos[$i]->move('mediafiles/pic_activity',$newname);
                // }else{
                //     $newname[$i] = $request->photos[$i]->getClientOriginalName();
                //     // dd($newname);
                //     $www_data_img = new www_data_img;

                //     $www_data_img->No = $www_data->No;
                //     $www_data_img->path_img = $newname[$i];
                //     $www_data_img->save();

                //     $request->photos[$i]->move('mediafiles/pic_activity',$newname[$i]);
                // }

                // }
                // }

            }
        }

        return redirect()->back()->with('message', 'แก้ไขสำเร็จ');
    }

    public function delete_img(Request $request)
    {
        $deletePic = www_data_img::where('Seq', $request->Seq)->where('No', $request->No)->get();
        unlink('mediafiles/pic_activity/' . $deletePic[0]->path_img);
        www_data_img::where('Seq', $request->Seq)->where('No', $request->No)->delete();
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

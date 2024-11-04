<?php

namespace App\Http\Controllers\Admin;

use App\Events\DataPublished;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\www_data;
use App\Model\admin\www_data_img;
use App\Model\admin\www_ucf_category;
use Illuminate\Support\Facades\Storage;
use Filesystem;
use File;

class Ws_postController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $_SELECTED = $_GET['Category'];
        $type = $_GET['type'];
        $Category = $_GET['Category'];
        if ($_GET['Category']) {
            $description = DB::select('SELECT *  FROM www_ucf_category WHERE type = :type ORDER BY description ASC', ['type' => $type]);
        } else {
            $description = DB::select('SELECT *  FROM www_ucf_category WHERE type = :type ORDER BY description ASC', ['type' => $type]);
        }

        $Category = www_ucf_category::where('category', Request('Category'))->first();


        return view('admin.part.ws_post', ['selected' => $_SELECTED, 'category' => $Category, 'description' => $description]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all(),$request->hasFile('pic_upload'));
        if (isset($request->Submit) && $request->lm_ucf_category != "") {
            //dd($request->QTitle,$request->QName ,strpos($request->QTitle,'<script>') ,strpos($request->QTitle,'<SCRIPT>') );

            $Question = $request->QTitle;
            $Name = $request->QName;

            if (strpos($Question, '<script>') !== false || strpos($Question, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            if (strpos($Name, '<script>') !== false || strpos($Name, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            // if ($request->hasFile('pic_upload')) {
            //     if (preg_replace('/[^ก-ฮ]/u', '', $request->pic_upload->getClientOriginalName())) {
            //         // $typePic = explode('.',$request->pic_upload->getClientOriginalName());
            //         // $Nameext = pathinfo($request->pic_upload->getClientOriginalName(), PATHINFO_FILENAME);
            //         $ext = pathinfo($request->pic_upload->getClientOriginalName(), PATHINFO_EXTENSION);

            //         $randname = rand();
            //         $imageName = $randname . '.' . $ext;
            //     } else {
            //         $imageName = $request->pic_upload->getClientOriginalName();
            //     }
            //     $request->pic_upload->move('mediafiles/picture', $imageName);
            // } else {
            //     $imageName = null;
            // }
            // if ($request->hasFile('file_upload')) {
            //     if (preg_replace('/[^ก-ฮ]/u', '', $request->file_upload->getClientOriginalName())) {
            //         // $typePic = explode('.',$request->file_upload->getClientOriginalName());
            //         // $Nameext = pathinfo($request->file_upload->getClientOriginalName(), PATHINFO_FILENAME);
            //         $ext = pathinfo($request->file_upload->getClientOriginalName(), PATHINFO_EXTENSION);
            //         $randname = rand();
            //         $fileName = $randname . '.' . $ext;
            //     } else {
            //         $fileName = $request->file_upload->getClientOriginalName();
            //     }
            //     $request->file_upload->move('mediafiles/data', $fileName);
            // } else {
            //     $fileName = null;
            // }

            $Category = $request->lm_ucf_category;
            $IP = f_get_ip();

            $typeDoc = empty($request->QTypeDoc) ? "" : "|" . $request->QTypeDoc;

            $www_data = new www_data;
            $www_data->Category = $Category;
            $www_data->Question = $request->QTitle . $typeDoc;
            $www_data->Note = empty($request->QNote) ? "" : $request->QNote;
            $www_data->Name = $request->QName;
            // $www_data->Namer = $request->body;
            $www_data->IP = $IP;
            $www_data->ReplayDate = empty($request->ReplayDate) ? null : $request->ReplayDate;
            // $www_data->Email = $request->status;
            $www_data->Date = DATETIME;
            $www_data->DataSort = -1;
            // $www_data->nphoto = $imageName;
            // $www_data->ndata = $fileName;
            $www_data->nphoto = $request->show_pic_upload;
            $www_data->ndata = empty($request->show_file_upload ) ? $request->show_file_upload2 : $request->show_file_upload;
            // $www_data->nlink = empty($request->show_file_upload2 ) ? '' : 'uselink';

            if ($www_data->save()) {

                DB::update(
                    "UPDATE www_data
                    SET
                    DataSort = DataSort+1
                    WHERE Category = :Category
                    and DataSort >= :DataSort",
                    ['Category' => $Category, 'DataSort' => -1]
                );

                if (count($request->photos) > 0 && $request->type == "G") {

                    //dd($request->fileRemove , $request->photos);
                    $ArrListImg = array();

                    for ($i = 0; $i < count($request->photos); $i++) {
                        array_push($ArrListImg, $request->photos[$i]->getClientOriginalName());
                    }

                    $ArrListImg = array_unique($ArrListImg);

                    if ($request->fileRemove != null) {
                        $cutfileName = explode(',', $request->fileRemove[0]);
                        // array_unique( $ArrListImg );

                        for ($j = 0; $j < count($cutfileName); $j++) {
                            if (($key = array_search($cutfileName[$j], $ArrListImg)) !== false) {
                                unset($ArrListImg[$key]);
                            }
                        }

                        $ArrListImg2 = [];

                        foreach ($ArrListImg as $tt) {
                            array_push($ArrListImg2, $tt);
                        }
                    }
                    //dd($request->all(),$ArrListImg);

                    //for( $i=0; $i < count($request->photos);$i++)
                    for ($i = 0; $i < count($ArrListImg2); $i++) {

                        if ($ArrListImg2[$i] != null) {

                            if (preg_replace('/[^ก-ฮ]/u', '', $ArrListImg2[$i])) {
                                // $typePic = explode('.',$ArrListImg2[$i]);
                                //$filename = pathinfo($request->photos[$i]->getClientOriginalName(), PATHINFO_FILENAME);
                                $randname = rand();
                                $ext = pathinfo($ArrListImg2[$i], PATHINFO_EXTENSION);
                                $newname = (string) $randname . '.' . $ext;
                                //dd('ไฟล์มีภาษาไทย',$filename, $request->photos[$i]->getClientOriginalExtension());
                            } else {
                                $newname[$i] = $ArrListImg2[$i];
                            }

                            $www_data_img = new www_data_img;
                            $www_data_img->No = $www_data->No;
                            // $www_data_img->path_img = $request->photos[$i]->getClientOriginalName();
                            $www_data_img->path_img = $newname[$i];
                            $www_data_img->save();

                            // $request->photos[$i]->move('mediafiles/pic_activity',$request->photos[$i]->getClientOriginalName());
                            $request->photos[$i]->move('mediafiles/pic_activity', $newname[$i]);
                        }
                    }
                }

                // even ไม่รองรับภาษาไทย
                if (!preg_replace('/[^ก-ฮ]/u', '', $request->QTitle) && !preg_replace('/[^ก-ฮ]/u', '', $request->QNote)) {
                    event(new DataPublished([
                        "title" => $request->QTitle,
                        "body"  => strip_tags(substr($request->QNote, 0, 40) . " ..."),
                        "url"   => $www_data->No
                    ]));
                }

                return redirect()->back()->with('message', 'บันทึกสำเร็จ');
            }

            return redirect()->back()->with('danger', 'บันทึกไม่สำเร็จ');
        }
    }

    public function upload_video(Request $request)
    {
        $IP = f_get_ip();
        //Edit Video upload
        if ($request->edit_video == 1) {


            $Question = $request->QTitle;
            $Name = $request->QName;
            $Nmedia = $request->nmedia;

            if (strpos($Question, '<script>') !== false || strpos($Question, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            if (strpos($Name, '<script>') !== false || strpos($Name, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            if (strpos($Nmedia, '<script>') !== false || strpos($Nmedia, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            //dd($request->all());
            $www_data = www_data::find($request->No);
            $www_data->Category = "video";
            $www_data->Question = $request->QTitle;
            $www_data->Note = empty($request->QNote) ? "" : $request->QNote;
            $www_data->Name = $request->QName;
            // $www_data->Namer = $request->body;
            $www_data->IP = $IP;
            // $www_data->Email = $request->status;
            $www_data->Date = DATETIME;
            $www_data->nphoto = null;
            $www_data->ndata = null;
            $www_data->nmedia = $request->nmedia;
            $www_data->save();

            return redirect()->back()->with('message', 'บันทึกสำเร็จ');
        } else {


            $Question = $request->QTitle;
            $Name = $request->QName;

            if (strpos($Question, '<script>') !== false || strpos($Question, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            if (strpos($Name, '<script>') !== false || strpos($Name, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            if (strpos($Nmedia, '<script>') !== false || strpos($Nmedia, '<SCRIPT>') !== false) {
                return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ เนื่องจากมี script javascript อยู่');
            }

            $www_data = new www_data;
            $www_data->Category = "video";
            $www_data->Question = $request->QTitle;
            $www_data->Note = empty($request->QNote) ? "" : $request->QNote;
            $www_data->Name = $request->QName;
            // $www_data->Namer = $request->body;
            $www_data->IP = $IP;
            // $www_data->Email = $request->status;
            $www_data->Date = DATETIME;
            $www_data->nphoto = null;
            $www_data->ndata = null;
            $www_data->nmedia = $request->nmedia;
            $www_data->save();

            return redirect()->back()->with('message', 'บันทึกสำเร็จ');
        }
    }

    // public function imageuploader(Request $request)
    // {
    //     dd($request->all());
    //     $files = $request->file('file');
    //     $files_name = $files->getClientOriginalName();
    //     $files->move('mediafiles/pic_activity',$files_name);

    //     // File::create([
    //     //     'title' => $files->getClientOriginalName(),
    //     //     'description' => 'Upload with dropzone',
    //     //     'path' => $files->store('public/mediafiles')
    //     // ]);
    //     // use Illuminate\Support\Facades\Storage;


    //     //$path = Storage::putFile('public/mediafiles', $files);
    // }

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

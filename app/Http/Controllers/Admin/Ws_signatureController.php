<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\admin\www_data as www_data;

class Ws_signatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $No = www_data::where('Category','signature')->orderBy('No','asc')->pluck('No');
        $signature = www_data::where('Category','signature')->orderBy('No','asc')->pluck('nphoto');
        $position = www_data::where('Category','signature')->orderBy('No','asc')->pluck('Question');
        $name = www_data::where('Category','signature')->orderBy('No','asc')->pluck('Note');
        
        return view('admin.part.ws_signature',compact('signature','position','name','No'));
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
       

        $countRow = www_data::where('Category','signature')->get();
        
        if( count($countRow) > 0 ):

            $delSignature = www_data::where('Category','signature')->orderBy('No','asc')->pluck('nphoto');

            // dd( $request->all()  );


        // // dd($delSignature);
            if($request->pic_signature[0] != null):

                // $Name = pathinfo($request->manager->getClientOriginalName(), PATHINFO_FILENAME);
                // $ext = pathinfo($request->manager->getClientOriginalName(), PATHINFO_EXTENSION);

                unlink('mediafiles/picture/' . $delSignature[0]);

                $update = www_data::find((int)$request->No[0]);
                $update->nphoto = $request->pic_signature[0]->getClientOriginalName();
                $update->Question = $request->position[0];
                $update->Note = $request->name[0];
                $update->save();

                $request->pic_signature[0]->move('mediafiles/picture',$request->pic_signature[0]->getClientOriginalName());

            endif;

            if($request->pic_signature[1] != null):

                unlink('mediafiles/picture/' . $delSignature[1]);

                $update = www_data::find((int)$request->No[1]);
                $update->nphoto = $request->pic_signature[1]->getClientOriginalName();
                $update->Question = $request->position[1];
                $update->Note = $request->name[1];
                $update->save();

                $request->pic_signature[1]->move('mediafiles/picture',$request->pic_signature[1]->getClientOriginalName());

            endif;
            
            $update1 = www_data::find((int)$request->No[0]);
            $update1->Note = $request->name[0];
            $update1->Question = $request->position[0];
            $update1->save();

            $update2 = www_data::find((int)$request->No[1]);
            $update2->Note = $request->name[1];
            $update2->Question = $request->position[1];
            $update2->save();

        else:
            for( $i = 0 ; $i < count($request->name) ; $i++ ):
                $update1 = new www_data;
                $update1->Category = 'signature';
                $update1->Question = $request->position[$i];
                $update1->Note = $request->name[$i];
                $update1->nphoto = $request->pic_signature[$i]->getClientOriginalName();
                $update1->Date = date('Y-m-d H:i:s');
                $update1->save();
            endfor;
        endif;

        return redirect()->back()->with('message','แก้ไขลายเซ็นเรียบร้อยแล้ว');
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
        //
    }
}

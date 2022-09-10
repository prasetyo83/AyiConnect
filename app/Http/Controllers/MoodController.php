<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Reason;
use App\Models\Feeling;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;


class MoodController extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {         
        if ($request->ajax()){
            $data = Mood::where('status',0)->orderBy('created_at','desc')->get();            
            
            return DataTables::of($data)
                ->editColumn('created_at', function ($data) {
                    return  date("d F Y h:i:s A", strtotime($data->created_at));
                })
                
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = "<a class='btn btn-sm btn-primary edit-mood' data-id='" . $data->textid . "' data-toggle='modal' data-target='#editMoodModal' title='Edit'><i class='fa fa-edit'></i></a>"." "."<a class='btn btn-sm btn-danger delete-mood' data-id='" . $data->textid . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                
                ->rawColumns(['actions'])
                ->make(true);                
           
        }
        return view('mood');
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
        if($request->ajax()){
            $newImgPath = "";
            if ($request->hasFile('img') != null){
                $image = $request->file('img');  
                $request->validate([
                    'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                  ]);

                //$storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
                $newFile = time() . "." . $image->getClientOriginalExtension();
                $newImgPath = "/storage/mood/".$newFile;
             
                if (isset($request->hidden_image) && strpos($request->hidden_image, "storage") > 0 ){
                    
                    Storage::disk('public')->delete('mood/'.str_replace("/storage/mood/","",$request->hidden_image));
                }
               
               Storage::putFileAs('public/mood', new File($image), $newFile);
               
            }elseif (isset($request->action) && $request->action == "edit"){
               if (strpos($request->hidden_image, "storage") > 0 ){
                    $newImgPath = $request->hidden_image;                   
                }
            }
            
            
            
            Mood::updateOrCreate(
                    ["id" =>$request->id],
                    ["title" =>trim(ucwords(strtolower($request->title))),
                        "image" => trim($newImgPath) != "" ? $newImgPath : ""
                    ]
                );
            
         }     
         
        Alert::success('Congrats', 'You\'ve Successfully Registered');
        return response()->json(['success' => 'Post saved successfully.']);
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mood  $mood
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(!isset($request)){
            $editData = Mood::where('status',0)->orderBy("title","asc")->get();
        }else{
            $editData = Mood::where('textid',$request->id)->get();
        }    
        
        return response()->json($editData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mood  $mood
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
        $editData = Mood::where('textid',$req->id)->first();
        return response()->json($editData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mood  $mood
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mood $mood)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mood  $mood
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dataRemove = Mood::where ('textid','=',$request->id)->first();        
        if ($dataRemove) {
            $dataRemove->status = '1';
            $dataRemove->save();            
            
            $resReason = Reason::where('mood_id','=',$dataRemove->id)->get();
            if ($resReason){
                foreach ($resReason as $value) {
                    $dataFeeling = Feeling::where('reason_id','=',$value->id)->update(["status" => '1']);
                }
            }
            
            $dataReason = Reason::where('mood_id','=',$dataRemove->id)->update(["status" => '1']);
            
        }
        return response()->json(['success' => 'Post deleted successfully.']);
    }
}

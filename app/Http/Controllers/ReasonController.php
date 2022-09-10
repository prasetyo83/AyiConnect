<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reason;
use App\Models\Mood;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Feeling;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $moods = Mood::select("id","textid","title")->where('status',0)->orderBy('title','asc')->get();
        
        if ($request->ajax()){            
            $data = Reason::where('status',0)->orderBy('created_at','desc')->get();            
            
            return DataTables::of($data)
                ->editColumn('created_at', function ($data) {
                    return  date("d F Y h:i:s A", strtotime($data->created_at));
                })
                
                ->editColumn('mood', function ($data) {
                    $mood_name = $this->getMood($data->mood_id);
                    return  $mood_name;
                })
                
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = "<a class='btn btn-sm btn-primary edit-reason' data-id='" . $data->textid . "' data-toggle='modal' data-target='#editReasonModal' title='Edit'><i class='fa fa-edit'></i></a>"." "."<a class='btn btn-sm btn-danger delete-reason' data-id='" . $data->textid . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                
                ->rawColumns(['actions'])
                ->make(true);                
           
        }
        return view('reason', compact('moods'));
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

    /**mood
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
                
                $newFile = time() . "." . $image->getClientOriginalExtension();
                $newImgPath = "/storage/reason/".$newFile;
             
                if (isset($request->hidden_image) && strpos($request->hidden_image, "storage") > 0 ){                    
                    Storage::disk('public')->delete('reason/'.str_replace("/storage/reason/","",$request->hidden_image));
                }
               
               Storage::putFileAs('public/reason', new File($image), $newFile);
               
            }elseif (isset($request->action) && $request->action == "edit"){
               if (strpos($request->hidden_image, "storage") > 0 ){
                    $newImgPath = $request->hidden_image;                   
                }
            }
            
            Reason::updateOrCreate(
                    ["id" =>$request->id],
                    ["mood_id" =>$request->mood,
                    "title" =>trim(ucwords(strtolower($request->title))),
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
    public function edit(Request $req)
    {
        $editData = Reason::where('textid',$req->id)->first();
        return response()->json($editData);
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
    public function destroy(Request $request)
    {
        $dataRemove = Reason::where ('textid','=',$request->id)->first();        
        if ($dataRemove) {
            $dataRemove->status = '1';
            $dataRemove->save();            
            $dataFeeling = Feeling::where('reason_id','=',$dataRemove->id)->update(["status" => '1']);
        }
        return response()->json(['success' => 'Post deleted successfully.']);
    }
    
    public function showMood(Request $request)
    {
        //dd($request);
        if($request->has('q')){
            $q = $request->q;              
            $editData = Mood::select("id","textid","title")->where([
                ["status","=","0"],
                ["title","LIKE","%$q%"]
            ])->orderBy('title','asc')->get();
        }elseif($request->has('id')){
            $editData = Mood::select("id","textid","title")->where([["status","=","0"],               
                ["textid","=",$request->id]])->get();
        }else{
            $editData = Mood::select("id","textid","title")->where('status',0)->orderBy('title','asc')->get();
        }    
        
       
        return response()->json($editData);
    }
    
    function getMood($id){
        if ((trim($id) != "") || ($id != Null)){
            $moodData = Mood::select("title")->where([["status","=","0"],               
                ["id","=",$id]])->first();
        
            return $moodData['title'];
        }
        
        return false;
    }
}

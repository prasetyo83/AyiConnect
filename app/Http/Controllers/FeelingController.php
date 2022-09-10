<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reason;
use App\Models\Feeling;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class FeelingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $reasons = DB::table("reason")
               ->select("reason.id","reason.textid",DB::raw("CONCAT(reason.title,' - ',mood.title) as title"))
               ->leftJoin("mood", function($join){
                   $join->on("mood.id","=","reason.mood_id");
               })->where('reason.status',0)                
               ->orderBy('reason.title','asc')->get();
        
        if ($request->ajax()){            
            $data = Feeling::where('status',0)->orderBy('created_at','desc')->get();            
            
            return DataTables::of($data)
                ->editColumn('created_at', function ($data) {
                    return  date("d F Y h:i:s A", strtotime($data->created_at));
                })
                
                ->editColumn('reason', function ($data) {
                    $reason_name = $this->getReason($data->reason_id);
                    return  $reason_name;
                })
                
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = "<a class='btn btn-sm btn-primary edit-feeling' data-id='" . $data->textid . "' data-toggle='modal' data-target='#editFeelingModal' title='Edit'><i class='fa fa-edit'></i></a>"." "."<a class='btn btn-sm btn-danger delete-feeling' data-id='" . $data->textid . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                
                ->rawColumns(['actions'])
                ->make(true);                
           
        }
        return view('feeling', compact('reasons'));
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
                $newImgPath = "/storage/feeling/".$newFile;
             
                if (isset($request->hidden_image) && strpos($request->hidden_image, "storage") > 0 ){                    
                    Storage::disk('public')->delete('feeling/'.str_replace("/storage/feeling/","",$request->hidden_image));
                }
               
               Storage::putFileAs('public/feeling', new File($image), $newFile);
               
            }elseif (isset($request->action) && $request->action == "edit"){
               if (strpos($request->hidden_image, "storage") > 0 ){
                    $newImgPath = $request->hidden_image;                   
                }
            }
            
            Feeling::updateOrCreate(
                    ["id" =>$request->id],
                    ["reason_id" =>$request->reason,
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
        $editData = Feeling::where('textid',$req->id)->first();
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
        $dataRemove = Feeling::where ('textid','=',$request->id)->first();        
        if ($dataRemove) {
            $dataRemove->status = '1';
            $dataRemove->save();
        }
        return response()->json(['success' => 'Post deleted successfully.']);
    }
    
    public function showReason(Request $request)
    {
        if($request->has('q')){
            $q = $request->q;              
            $editData = DB::table("reason")
                    ->select("reason.id","reason.textid",DB::raw("CONCAT(reason.title,' - ',mood.title) as title"))
                    ->leftJoin("mood", function($join){
                        $join->on("mood.id","=","reason.mood_id");                        
                    })
                            ->where('reason.status',0)
                            ->where('reason.title',"LIKE","%$q%")
                            ->orWhere('mood.title',"LIKE","%$q%")
                            ->orderBy('reason.title','asc')->get();
        }elseif($request->has('id')){
            $editData = DB::table("reason")
               ->select("reason.id","reason.textid",DB::raw("CONCAT(reason.title,' - ',mood.title) as title"))
               ->leftJoin("mood", function($join){
                   $join->on("mood.id","=","reason.mood_id");
               })->where([["reason.status","=","0"],               
                ["reason.mood_id","=",$request->id]])->get();
        }else{           
            $editData = DB::table("reason")
               ->select("reason.id","reason.textid",DB::raw("CONCAT(reason.title,' - ',mood.title) as title"))
               ->leftJoin("mood", function($join){
                   $join->on("mood.id","=","reason.mood_id");
               })->where('reason.status',0)                
               ->orderBy('reason.title','asc')->get();
        }  
         
        
       
       
        return response()->json($editData);
    }
    
    public function showFeeling(Request $request)
    {
        //dd($request);
        if($request->has('q')){
            $q = $request->q;              
            $editData = Feeling::select("id","textid","title")->where([
                ["status","=","0"],
                ["title","LIKE","%$q%"]
            ])->orderBy('title','asc')->get();
        }elseif($request->has('id')){
            $editData = Feeling::select("id","textid","title")->where([["status","=","0"],               
                ["reason_id","=",$request->id]])->get();
        }else{
            $editData = Feeling::select("id","textid","title")->where('status',0)->orderBy('title','asc')->get();
        }    
        
       
        return response()->json($editData);
    }
    
    function getReason($id){
        if ((trim($id) != "") || ($id != Null)){
            $resData = Reason::select("title")->where([["status","=","0"],               
                ["id","=",$id]])->first();
        
            return $resData['title'];
        }
        
        return false;
    }
}

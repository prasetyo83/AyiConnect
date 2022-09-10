<?php

namespace App\Http\Controllers;

use App\Models\Authorsocial;
use App\Models\Social;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuthorSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id,Request $request)
    {
        //
        if ($request->ajax()) {
            $dSocial =  Authorsocial::where('author_id',$id)->get();          
            // dd($dSocial);
            return DataTables::of($dSocial)
                ->editColumn('created_at', function ($dSocial) {
                    return  date("d-M-Y h:i:sa", strtotime($dSocial->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dSocial) {
                   
                    $btn = "<a class='btn btn-sm btn-primary edit-social' data-id='" . $dSocial->id . "' data-toggle='modal' data-target='#editlinkModal' title='Edit'><i class='fa fa-edit'></i></a>" . "|" . "<a class='btn btn-sm btn-danger delete-social' data-id='" . $dSocial->id . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })               
                ->editColumn('network', function ($dSocial) {
                    $socialName = "";
                    if (trim($dSocial->social_id) != ""){
                        $dataSocial = Social::where("id","$dSocial->social_id")->get();                     
                        if (count($dataSocial) > 0) $socialName = $dataSocial[0]->name;
                    }
                    
                    return $socialName;
                })
               
                
                ->rawColumns(['operate','network'])
                ->make(true);
        }
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
        Authorsocial::updateOrCreate(
            ['id' => $request->id],
            [
                'author_id' => $request->author_id, 'link' => $request->link, 'social_id' => $request->network
            ]
        );
        // Alert::success('Congrats', 'You\'ve Successfully Registered');
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
    public function edit($id)
    {
        $post = Authorsocial::where('id','=',$id)->first();
        // dd($post);
        return response()->json($post);
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
        $page = Authorsocial::where ('id','=',$id)->first();
        // Make sure you've got the Page model
        if ($page) {
           $page->delete();
        }
        return response()->json(['success' => 'Link deleted successfully.']);
    }
    
    
    public function fetchsocial(Request $request){ 
        
        if($request->has('q')){
            $q = trim($request->q);              
            $resData = Social::select("id","name","icon")->where([
                ["status","=","0"],
                ["name","LIKE","%$q%"]
            ])->orderBy('row_order','asc')->get();
        }elseif ($request->has('id')){
            $resData = Social::select("id","name","icon")->where([["status","=","0"],               
                ["id","=",$request->id]])->get();            
        }else{
            $resData = Social::select("id","name","icon")->where("status","0")->orderBy('row_order','asc')->get();
        }
        
        return response()->json($resData);
    }
}

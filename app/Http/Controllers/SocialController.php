<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $dataSocial =  Social::where('status',0)->get();
            return DataTables::of($dataSocial)
                ->editColumn('created_at', function ($dataSocial) {
                    return  date("d-M-Y h:i:sa", strtotime($dataSocial->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dataSocial) {
                    $btn = "<a class='btn btn-sm btn-primary edit-social' data-id='" . $dataSocial->id . "' data-toggle='modal' data-target='#editSocialModal' title='Edit'><i class='fa fa-edit'></i></a>"." "."<a class='btn btn-sm btn-danger delete-social' data-id='" . $dataSocial->id . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })              
                ->addColumn('icon', function ($dataSocial) {
                    $icon = "<span>".$dataSocial->icon." <i class='".$dataSocial->icon."'></i></span>";
                    return $icon;
                })
                ->rawColumns(['operate','icon'])
                ->make(true);
        }
       
        return view('social');
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
            Social::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->social_name,
                    'icon' => $request->icon
                ]
            );
            return response()->json(['success' => 'Post saved successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function show(Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
        $editData = Social::where('id',$req->id)->first();
        return response()->json($editData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Social $social)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->ajax()){
            $dataRemove = Social::where ('id','=',$request->id)->first();        
            if ($dataRemove) {
                $dataRemove->status = '1';
                $dataRemove->save();
            }
            return response()->json(['success' => 'Post deleted successfully.']);
        }
    }
    
    /*
     * reoder social on social table
     * 
     *
     */
    
    public function reorder(Request $request)
    {
        foreach($request->input('rows', []) as $row)
        {
            Social::find($row['id'])->update([
                'row_order' => $row['position']
            ]);
        }
        return response()->noContent();
    }
}

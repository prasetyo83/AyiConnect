<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $response = array();
    protected $access_key = "6808";
    public function __construct()
    {
        
    }
    public function index(Request $request)
    {
        
        if (isset($request->acces_key)&&(isset($request->categorie_list_v2)))
        {
            if ($this->access_key != $request->acces_key) {
                $this->response['error'] = "true";
                $this->response['message'] = "Invalid Access Key";
                // print_r(json_encode($response));
                return response()->json($this->response);
            }
        }
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

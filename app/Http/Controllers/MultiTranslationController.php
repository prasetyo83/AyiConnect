<?php

namespace App\Http\Controllers;

use App\Models\MultiTranslation;
use Illuminate\Http\Request;

class MultiTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            MultiTranslation::updateOrCreate(
                    ["textid" =>$request->id, "lang" => $request->country],
                    ["textid" =>$request->id,
                    "text" =>trim($request->newquote),
                    "lang" => $request->country
                    ]
                );
         }     
       
        return response()->json(['success' => 'Post saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MultiTranslation  $multiTranslation
     * @return \Illuminate\Http\Response
     */
    public function show(MultiTranslation $multiTranslation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MultiTranslation  $multiTranslation
     * @return \Illuminate\Http\Response
     */
    public function edit(MultiTranslation $multiTranslation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MultiTranslation  $multiTranslation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MultiTranslation $multiTranslation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MultiTranslation  $multiTranslation
     * @return \Illuminate\Http\Response
     */
    public function destroy(MultiTranslation $multiTranslation)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Categories;
use App\Models\Quotes;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
//             $wordlist = Wordlist::where('id', '<=', $correctedComparisons)->get();
// $wordCount = $wordlist->count();
            $sections = Section::where('status',0)->get();
            $countSection= $sections->count();
            $categories = Categories::where('status',0)->get();
            $countCategories= $categories->count();
            $authors = Author::where('delete',0)->get();
            $countAuthor= $authors->count();
            $quotes = Quotes::where('status',0)->get();
            $countQuotes= $quotes->count();

            $users = User::where('status',0)->get();
            $countUsers= $users->count();

            return response()->json([
                'section' => $countSection,
                'categories' => $countCategories,
                'author' => $countAuthor,
                'quotes' => $countQuotes,
                'users' => $countUsers,
            ]);
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

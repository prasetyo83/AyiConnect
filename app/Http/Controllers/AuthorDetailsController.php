<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Authorbook;
use App\Models\Authorsocial;
use App\Models\Countries;
use App\Models\Quotes;
use App\Models\Social;
//use App\Models\BookStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $id;
    public function index($id)
    {
        // dd($id);
        $this->id = $id;
        $authors = Author::where('id', $id)->where('delete', '0')->first();
        $quotes = Quotes::where('author_id', $id)->where("status", "0")->get();
        $social = Social::where("status", "0")->get();
        //$store = BookStore::where("status", "0")->get();        
        $counts = count($quotes);
        $countries = Countries::all();
        //    dd($authors);
        return view('authors-detail', compact('authors', 'countries', 'counts', 'social'));
    }
    public function chart($id)
    {
        $data = DB::table('quotes')
            ->where('author_id', '=', $id)
            ->join('quotes_categories', 'quotes.id', '=', 'quotes_categories.quote_id')
            ->join('categories', 'categories.id', '=', 'quotes_categories.categories_id')
            ->select(array('categories.name', DB::raw('COUNT(quotes_categories.categories_id) as jumlah')))
            ->groupBy('categories.name')
            ->orderBy('jumlah', 'desc')
            ->limit(3)
            ->get();

            return response()->json($data);
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
    public function socialstore(Request $request)
    {

        // die($pre);

    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Authorbook  $authorbook
     * @return \Illuminate\Http\Response
     */
    public function show(Authorbook $authorbook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Authorbook  $authorbook
     * @return \Illuminate\Http\Response
     */
    public function edit(Authorbook $authorbook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Authorbook  $authorbook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Authorbook $authorbook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Authorbook  $authorbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authorbook $authorbook)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quotes;
use App\Models\QuotesCategories;
use App\Models\Author;
use App\Models\Authorbook;
use App\Models\Authorhastag;
use App\Models\Authorsocial;
use App\Models\Categories;
use App\Models\Mood;
use App\Models\Reason;
use App\Models\Feeling;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\MultiTranslation;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        $moods = Mood::select("id","textid","title")->where('status',0)->orderBy('title','asc')->get();
        $reasons = Reason::select("id","textid","title")->where('status',0)->orderBy('title','asc')->get();
        $feelings = Feeling::select("id","textid","title")->where('status',0)->orderBy('title','asc')->get();
        
        $author = Author::select("id","name")->where("delete","0")->orderBy('name','asc')->get();
        $authorbook = Authorbook::select("id","title")->where("status","0")->orderBy('title','asc')->get();
        
        $categories = Categories::select("id","name")->where("status","0")->orderBy('name','asc')->get();
        
        return view('quotes', compact("moods","reasons","feelings","author","authorbook","categories"));
    }
    
    public function datatable(Request $request){
        
        if ($request->ajax()) {
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        $data = Quotes::when($search != "",function($query){
            $query->where("quote","LIKE","%".trim($_GET['search'])."%");        
        })->where('status',0)->orderBy('created_at','desc')->paginate($limit);
        
        $dataItems = $data->items();        
        $rows = array();
        $tempRow = array();
        foreach ($dataItems as $row) {            
            $actions = "<a class='btn btn-xs btn-primary edit-quote' data-id='" . $row->textid . "' data-toggle='modal' data-target='#editQuoteModal' title='Edit'><i class='fa fa-edit'></i></a>";
            $actions .= " <a class='btn btn-xs btn-danger delete-quote' data-id='" . $row->textid . "' title='Delete'><i class='fa fa-trash'></i></a>";
            
            $resQCat = QuotesCategories::where("quote_id","=",$row->id)->where("status","=","0")->get();           
            $strCat="";
            if ($resQCat){
                 foreach($resQCat as $val){
                     $resData = Categories::where([["status","=","0"], ["id","=","$val->categories_id"]])->first();                    
                     if ($resData){                         
                         $strCat .= "<button class='btn btn-xs btn-success mr3'>".$resData->name."</button>";
                     }
                 }
            }
             
            $resLang = MultiTranslation::where("textid","=","$row->textid")->where("status","=","0")->get();                   
            $langCell = "<span class='cell-flag'>";
            if ($resLang){
                foreach ($resLang as $key =>$code){
                    $langCell .="<button type='button' class='btn btn-flag-lang btn-xs'>". $code->lang."</button>";
                }                    
            }
            $langCell .= "<button type='button' class='btn btn-primary btn-xs add-multi' data-textid='" . $row->textid . "' data-toggle='modal' data-target='#multiModal'>add</button></span>";
            
            $authorBookText = "";                   
            if (($row->authorbook_id != NULL)||(trim($row->authorbook_id) != "")){
                 $resBook = Authorbook::select("title")->where([["status","=","0"],["id","=","$row->authorbook_id"]])->get();
                 if (count($resBook) > 0){
                     $authorBookText = $resBook[0]->title;
                 } 
             }
            
            $authorData = Author::select("id","name")->where([["delete","=","0"], ["id","=","$row->author_id"]])->orderBy('name','asc')->first();
            $authorName = "";
            if ($authorData){
                $authorName = $authorData->name;
            }
                    
            $tempRow["id"] = $row->id;
            $tempRow["categories"] = $strCat;
            $tempRow["author_id"] = $row->author_id;
            $tempRow["author"] = $authorName;
            $tempRow["authorbook_id"] = $row->authorbook_id;
            $tempRow["authorbook"] = $authorBookText;
            $tempRow["quote"] = $row->quote;
            $tempRow["translation"] = $langCell;
            $tempRow["reminder"] = $row->reminder == 1 ? "<i class='fas fa-bell blue'></i>" : "<i class='fas fa-bell-slash'></i>";
            $tempRow["created_at"] = date("d-m-Y h:i:s A", strtotime($row->created_at));
            $tempRow["action"] = $actions;
            $rows[] = $tempRow;
        }
        $bulkData ["total"] = $data->total();
        $bulkData["rows"] = $rows;
        print_r(json_encode($bulkData));
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
    
    public function author($id, Request $request)
    {   // //
        if ($request->ajax()) {
            $dQuotes =  Quotes::where('status',   0)->where("author_id",$id)->get();
           
            return DataTables::of($dQuotes)

                ->editColumn('created_at', function ($dQuotes) {
                    return  date("d-M-Y h:i:sa", strtotime($dQuotes->created_at));
                })
                ->editColumn('categories', function ($dQuotes) {  
                    
                    $resQCat = QuotesCategories::where("quote_id","=",$dQuotes->id)->where("status","=","0")->get();
                    $strCat="";
                    foreach($resQCat as $val){
                        $resData = Categories::where([["status","=","0"], ["id","=",$val->categories_id]])->first();
                        if ($resData){
                            $strCat .= "<button class='btn btn-xs btn-success mr3'>".$resData->name."</button>";
                        }
                    }
                      
                    return $strCat;
                 })
                 ->editColumn('book',function ($dQuotes){
                    $authorBookText = "";
                    if (($dQuotes->authorbook_id != NULL)||(trim($dQuotes->authorbook_id) != "")){
                        $resBook = Authorbook::select("title")->where([["status","=","0"],               
                        ["id","=","$dQuotes->authorbook_id"]])->get(); 
                        if (count($resBook) > 0){
                            $authorBookText = $resBook[0]->title;
                        }
                    }
                    return $authorBookText;
                }) 
                ->addIndexColumn()
                ->addColumn('operate', function ($dQuotes) {
                   
                    $btn = "<a class='btn btn-sm btn-primary edit-auth' data-id='" . $dQuotes->id . "' data-toggle='modal' data-target='#editAuthorModal' title='Edit'><i class='fa fa-edit'></i></a>" . "|" . "<a class='btn btn-sm btn-danger delete-author' data-id='" . $dQuotes->id . "' title='Delete'><i class='fa fa-trash'></i></a>" . "|" . "<a class='btn btn-sm btn-info detail-author' data-id='" . $dQuotes->id . "' title='Detail' href='/authorsdetail/".$dQuotes->id."'><i class='fa fa-circle-info'></i></a>";
                    return $btn;
                })                
                
                ->rawColumns(['operate', 'categories'])
                ->make(true);
        }
        // return view('author');
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
               
            $resQuote = Quotes::updateOrCreate(
                ["id" =>$request->id],
                [
                    "author_id" =>$request->author,
                    "authorbook_id" =>$request->authorbook,
                    "mood_id" =>$request->mood,
                    "reason_id" =>$request->reason,
                    "feeling_id" =>$request->feeling,
                    "quote" =>trim($request->quote),
                    "reminder" =>$request->reminder=="on"?1:0
                ]
            );
            // dd($request->author)      ;  
            if ($resQuote){
                $arrCat = $request->categories;
                foreach ($arrCat as $val){                    
                    if (!QuotesCategories::where([["status","=","0"],["categories_id","=",$val],["quote_id","=",$resQuote->id]])->exists()){
                        if (QuotesCategories::where([["status","=","1"],["categories_id","=",$val],["quote_id","=",$resQuote->id]])->exists()){
                            /* update categories if they have inserted before */
                            QuotesCategories::where('categories_id', $val)->where('quote_id', $resQuote->id)->update(['status' => 0]);
                        }else{
                            /* create new quote categories */
                            QuotesCategories::create([
                               "quote_id" => $resQuote->id,
                                "categories_id" => $val
                            ]);
                        }
                    }
                }
                
                /* 
                 * bulk delete quotes categories with categories unused/removed 
                 */
                QuotesCategories::where("quote_id",$resQuote->id)->whereNotIn("categories_id",$arrCat)->update(['status'=>1]);
                
            }
            
         }          
        
        return response()->json(['success' => 'Post saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function show(Quotes $quotes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {  
        $resData = Quotes::where('textid',$req->id)->get();
        
        $arrQuotes = array();
        foreach ($resData as $key =>$val){
            $arrQuotes['id'] = $val->id;
            $arrQuotes['textid'] = $val->textid;
            $arrQuotes['quote'] = $val->quote;
            $arrQuotes['author_id'] = $val->author_id;
            $arrQuotes['authorbook_id'] = $val->authorbook_id;
            $arrQuotes['mood_id'] = $val->mood_id;
            $arrQuotes['reason_id']= $val->reason_id;
            $arrQuotes['feeling_id']= $val->feeling_id;
            $arrQuotes['reminder']= $val->reminder;
            
            $resCategories = QuotesCategories::select("categories_id")->where([["status","=","0"],               
                ["quote_id","=",$val->id]])->get()->toArray();
        
            $arrCat= array();
            foreach($resCategories as $cat){
                $arrCat[] = $cat['categories_id'];

            }
            
            $arrQuotes['categories'] = $arrCat;
                    
        }        
        
        return response()->json($arrQuotes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotes $quotes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $dataRemove = Quotes::where ('textid','=',$request->id)->first();        
        if ($dataRemove) {
            QuotesCategories::where("quote_id",$dataRemove->id)->update(['status'=>1]);
            $dataRemove->status = '1';
            $dataRemove->save();
        }
        return response()->json(['success' => 'Post deleted successfully.']);
    }
    
    
    public function fetchauthor(Request $request){        
        if($request->has('q')){
            $q = $request->q;              
            $resData = Author::select("id","name")->where([
                ["delete","=","0"],
                ["name","LIKE","%$q%"]
            ])->orderBy('name','asc')->get();
        }elseif ($request->has('id')){
            $resData = Author::select("id","name")->where([["delete","=","0"],               
                ["id","=",$request->id]])->get();            
        }else{
            $resData = Author::select("id","name")->where("delete","0")->orderBy('name','asc')->get();
        }
        
        return response()->json($resData);
    }
    
    public function fetchbook(Request $request){ 
        
        if($request->has('q')){
            $q = $request->q;              
            $resData = Authorbook::select("id","title")->where([
                ["status","=","0"],
                ["title","LIKE","%$q%"]
            ])->orderBy('title','asc')->get();
        }elseif ($request->has('id')){
            $resData = Authorbook::select("id","title")->where([["status","=","0"],               
                ["author_id","=",$request->id]])->get();            
        }else{
            $resData = Authorbook::select("id","title")->where("status","0")->orderBy('title','asc')->get();
        }
        
        return response()->json($resData);
    }
    
    public function fetchcategory(Request $request){ 
        
        if($request->has('q')){
            $q = $request->q;              
            $resData = Categories::select("id","name")->where([
                ["status","=","0"],
                ["name","LIKE","%$q%"]
            ])->orderBy('name','asc')->get();
        }elseif ($request->has('id')){
            $resData = Categories::select("id","name")->where([["status","=","0"],               
                ["id","=",$request->id]])->get();            
        }else{
            $resData = Categories::select("id","name")->where("status","0")->orderBy('name','asc')->get();
        }
        
        return response()->json($resData);
    }
    
    public function fetchcountry(Request $request){ 
        
        if($request->has('q')){
            $q = $request->q;  
            $result = DB::table('countries')->select("country_code","country_name")->where("country_name","LIKE","%$q%")->orWhere("country_code","LIKE","%$q%")->orderBy("country_name","asc")->get();
        }elseif ($request->has('id')){
            $result = DB::table('countries')->select("country_code","country_name")->where("country_code",$request->id)->get();                        
        }else{
            $result = DB::table('countries')->select("country_code","country_name")->orderBy("country_name","asc")->get();
        }
        
        return response()->json($result);
    }    
}

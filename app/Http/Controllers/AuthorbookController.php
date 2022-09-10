<?php

namespace App\Http\Controllers;

use App\Models\Authorbook;
use App\Models\Authorbookcountries;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AuthorbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        // $dBook =  Authorbook::where('author_id',$id)->get();          
        //     dd($dBook);
        if ($request->ajax()) {
            // dd($id);
            $dBook =  Authorbook::where('author_id', '=', $id)->where("status", "0")->get();
            // $dCategory->section->section_name
            // dd($dBook->author_id);
            return DataTables::of($dBook)
                ->editColumn('created_at', function ($dBook) {
                    return  date("d-M-Y h:i:sa", strtotime($dBook->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dBook) {

                    $btn = "<a class='btn btn-sm btn-primary edit-book' data-id='" . $dBook->id . "' data-toggle='modal' data-target='#editBookModal' title='Edit'><i class='fa fa-edit'></i></a>" . "|" . "<a class='btn btn-sm btn-danger delete-book' data-id='" . $dBook->id . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                ->editColumn('image', function ($dBook) {
                    if ($dBook->image != null) {

                        $img = "<img src='/storage/book/" .  $dBook->image . "' height='50' width='50'></img>";
                    } else {
                        $img = "No Image";
                    }
                    return  $img;
                })
                ->editColumn('country_code', function ($dBook) {
                    // $resQauthorbook=Authorbook::where('author_id',$dBook->author)
                    $resQCat = Authorbookcountries::where("authorbook_id", "=", $dBook->id)->get();
                    $strCat = "";
                    foreach ($resQCat as $val) {
                        // $resData = Categories::where([["status","=","0"], ["id","=",$val->categories_id]])->first();
                        $strCat .= "<button class='btn btn-xs btn-success mr3'>" . $val->country_code . "</button>";
                    }

                    return $strCat;

                    // return   $dBook->authorbookcountries->country_code;
                })

                ->rawColumns(['operate', 'country_code', 'image'])
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

        if ($request->file('image') != null) {
            $files = $request->file('image');
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


            if ($request->hidden_image != null) {
                // dd($request->hidden_image);
                $ad = "book/" . $request->hidden_image;
                // dd($ad);
                Storage::disk('public')->delete($ad);
            }
            // $authorImage = "book" . date('YmdHis') . "." . $files->getClientOriginalExtension();

            //insert new file
            // $destinationPath = 'public/uploads/'; // upload path
            $bookImage = "book_" . date('YmdHis') . "." . $files->getClientOriginalExtension();
            Storage::putFileAs('public/book', new File($files), $bookImage);
            $image = "$bookImage";
        } else {
            $image = $request->hidden_image;
        }
        // die($pre);
        $save = Authorbook::updateOrCreate(
            ['id' => $request->id],
            [
                'author_id' => $request->author_id, 'link' => $request->link,
                'image' => $image,
                'title' => $request->title

            ]
        );
        // dd($save->id);
        $ac = Authorbookcountries::where('authorbook_id', $save->id)->get();
        // dd($ac);
        if ($ac) {
            $arrCount = $request->country_code;
            if (is_array($arrCount) && (count($arrCount) > 0) && (isset($request->country_code))){
                foreach ($arrCount as $val) {

                     //dd($val);
                    //echo "val country:".$val."\n";

                    $auhast = $ac->where('country_code', '=', $val)
                        ->first();
                    // dd($auhast);
                    if ($auhast == null) {
                        Authorbookcountries::create([
                            'authorbook_id' => $save->id,
                            'country_code' => $val
                        ]);
                        //echo $save->id." insert $val";
                    }
                }
            }
            if ($request->deltag != "") {
                $myDel = explode(',', $request->deltag);
    
                foreach ($myDel as $del) {
                  
                    $auhast = Authorbookcountries::select('id')
                        ->where('authorbook_id', '=', $save->id)
                        ->where('country_code', '=', $del)
                        ->first();
                    // dd($auhast);
                    if ($auhast) {
    
                        $auhast->delete();
                    }
                    // }
                }
            }
        } else {
            $arrCount = $request->country_code;
           if (is_array($arrCount) && (count($arrCount) > 0) && (isset($request->country_code))){
                foreach ($arrCount as $val) {
                    Authorbookcountries::Create(
                        [
                            'authorbook_id' => $save->id, 'country_code' => $val,

                        ]
                    );
                }
            }
        }



        return response()->json(['success' => 'Authorbook saved successfully.']);
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
        // $post = Authorbook::where('id', $id)->first();
        // // dd($post->toJson());
        // return response()->json($post);
        $resData = Authorbook::where('id', $id)->where('status', 0)->get();

        $arrQuotes = array();
        foreach ($resData as $key => $val) {
            $arrQuotes['id'] = $val->id;
            $arrQuotes['title'] = $val->title;
            $arrQuotes['link'] = $val->link;
            $arrQuotes['image'] = $val->image;


            $resCountry = Authorbookcountries::select("country_code")->where([
                ["authorbook_id", "=", $val->id]
            ])->get()->toArray();

            $arrCat = array();
            foreach ($resCountry as $cat) {
                $arrCat[] = $cat['country_code'];
            }

            $arrQuotes['country_code'] = $arrCat;
        }

        return response()->json($arrQuotes);
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
        //
        $page = Authorbook::where('id', '=', $id)->first();
        // Make sure you've got the Page model
        if ($page) {
            $page->status = '1';
            $page->save();
            Authorbookcountries::where('authorbook_id', $id)->delete();
            //  if ($daut)
        }
        return response()->json(['success' => 'Author deleted successfully.']);
    }
}

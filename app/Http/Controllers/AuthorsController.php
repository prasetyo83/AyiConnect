<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Authorhastag;
use App\Models\Hastag;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $hastags = Hastag::where('status', 0)->get();
        if ($request->ajax()) {
            $dAuthor =  Author::where('delete',   0)->get();

            // foreach ($dAuthor as $d) {
            //     dd($d->authorhastag);
            // }
            // dd($dAuthor->authorhastag->hastag()->hastag);
            return DataTables::of($dAuthor)

                ->editColumn('created_at', function ($dAuthor) {
                    return  date("d-M-Y h:i:sa", strtotime($dAuthor->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dAuthor) {

                    $btn = "<a class='btn btn-sm btn-primary edit-auth' data-id='" . $dAuthor->id . "' data-toggle='modal' data-target='#editAuthorModal' title='Edit'><i class='fa fa-edit'></i></a>" . "|" . "<a class='btn btn-sm btn-danger delete-author' data-id='" . $dAuthor->id . "' title='Delete'><i class='fa fa-trash'></i></a>" . "|" . "<a class='btn btn-sm btn-info detail-author' data-id='" . $dAuthor->id . "' title='Detail' href='/authorsdetail/" . $dAuthor->id . "'><i class='fa fa-circle-info'></i></a>";
                    return $btn;
                })
                ->editColumn('premium', function ($dAuthor) {
                    $prem = ($dAuthor->premium == 1) ? "<a class='btn btn-sm btn-primary'> <i class='fa-solid fa-award'></i></a>" : "<a class='btn btn-sm btn-danger'><i class='fa-solid fa-star-half'></i></a>";
                    return  $prem;
                })
                ->editColumn('image', function ($dAuthor) {
                    // 
                    if ($dAuthor->image == null) {
                        $img = "No Image";
                    } else {

                        $img = "<img src='/storage/author/" .  $dAuthor->image . "' height='50' width='50'></img>";
                    }
                    return  $img;
                })
                ->rawColumns(['operate', 'premium', 'image'])
                ->make(true);
        }
        return view('authors', compact('hastags'));
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

        // dd($request->hastag);
        if ($request->has('premium')) {
            //Checkbox checked
            $pre = 1;
        } else {
            $pre = 0;
        }
        // dd($request->file('image'));
        if ($request->file('image') != null) {
            $files = $request->file('image');
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            //delete old file
            if ($request->hidden_image != null) {
                // dd($request->hidden_image);
                $ad = "author/" . $request->hidden_image;
                // dd($ad);
                Storage::disk('public')->delete($ad);
            }
            //insert new file
            // $destinationPath = 'public/uploads/'; // upload path
            $authorImage = "author_" . date('YmdHis') . "." . $files->getClientOriginalExtension();
            Storage::putFileAs('public/author', new File($files), $authorImage);
            // $files->move($destinationPath, $authorImage);
            $image = "$authorImage";
        } else {
            $image = $request->hidden_image;
        }
        // die($pre);
        $save = Author::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'image' => $image,
                'premium' => $pre,
                'delete' => '0',


            ]
        );
        // dd($myArHastag);
        foreach ($request->hastag as $hastag) {
            $reshas = Hastag::where('id', $hastag)->first();
            // dd($reshas);
            if ($reshas) {
                $auhast = Authorhastag::select('id')
                    ->where('author_id', '=', $save->id)
                    ->where('hastag_id', '=', $reshas->id)
                    ->first();
                // dd($auhast);
                if (!$auhast) {
                    Authorhastag::create([
                        'author_id' => $save->id,
                        'hastag_id' => $reshas->id,
                    ]);
                }
            }
        }
        if ($request->deltag != "") {
            $myDel = explode(',', $request->deltag);

            foreach ($myDel as $del) {
              
                $auhast = Authorhastag::select('id')
                    ->where('author_id', '=', $save->id)
                    ->where('hastag_id', '=', $del)
                    ->first();
                // dd($auhast);
                if ($auhast) {

                    $auhast->delete();
                }
                // }
            }
        }



        return response()->json(['success' => 'Author saved successfully.']);
    }
    public function store_hastag(Request $request)
    {
        Hastag::updateOrCreate(
            ['id' => $request->id],
            [
                'hastag' => $request->hastag
            ]
        );
        return response()->json(['success' => 'Post saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Author::where('id', '=', $id)->first();
        // dd($post);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $page = Author::where('id', '=', $id)->first();
        // Make sure you've got the Page model
        if ($page) {
            $page->delete = '1';
            $page->save();
        }
        return response()->json(['success' => 'Author deleted successfully.']);
    }
    public function reorder(Request $request)
    {
        foreach ($request->input('rows', []) as $row) {
            Author::find($row['id'])->update([
                'row_order' => $row['position']
            ]);
        }
        return response()->noContent();
    }
    public function getHastag(Request $request)
    {
       
        // return $data;
        if ($request->has('q')) {
            $q = $request->q;
            $editData = Hastag::select("id", "textid", "hastag")->where([
                ["status", "=", "0"],
                ["hastag", "LIKE", "%$q%"]
            ])->orderBy('hastag', 'asc')->get();
        } elseif ($request->has('id')) {
            $editData = Hastag::select("id", "textid", "hastag")->where([
                ["status", "=", "0"],
                ["textid", "=", $request->id]
            ])->get();
        } else {
            $editData = Hastag::select("id", "textid", "hastag")->where('status', 0)->orderBy('hastag', 'asc')->get();
        }


        return response()->json($editData);
    }
}

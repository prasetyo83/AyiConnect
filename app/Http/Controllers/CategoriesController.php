<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Models\Categories;
use App\Models\Quotes;
use App\Models\QuotesCategories;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $sections = Section::where('status',   0)->get(['id', 'section_name AS text']);


        if ($request->ajax()) {

            $dCategory =  Categories::where('status',   0)->get();
            // dd($dCategory);
            return DataTables::of($dCategory)
                ->editColumn('created_at', function ($dCategory) {
                    return  date("d-M-Y h:i:sa", strtotime($dCategory->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dCategory) {
                    $btn = "<a class='btn btn-sm btn-primary edit-categories' data-id='" . $dCategory->textid . "' data-toggle='modal' data-target='#editCategoriesModal' title='Edit'><i class='fa fa-edit'></i></a>" . "|" . "<a class='btn btn-sm btn-danger delete-categories' data-id='" . $dCategory->textid . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                ->editColumn('premium', function ($dCategory) {
                    $prem = ($dCategory->premium == 1) ? "<a class='btn btn-sm btn-primary'> <i class='fa-solid fa-award'></i></a>" : "<a class='btn btn-sm btn-danger'><i class='fa-solid fa-star-half'></i></a>";
                    return  $prem;
                })
                ->editColumn('section_name', function ($dCategory) {
                    if ($dCategory->section==null)
                    {
                        $section_name='-';
                    }
                    else
                    {

                        $section_name = $dCategory->section->section_name;
                    }
                    return  $section_name;
                })
                ->editColumn('quoted', function ($dCategory) {
                    // 
                    $resQCat = QuotesCategories::where("categories_id", "=", $dCategory->id)->get();

                    return  $resQCat->count();
                })
                ->editColumn('image', function ($dCategory) {
                    // 
                    if ($dCategory->image != null) {

                        $img = "<img src='/storage/categories/" .  $dCategory->image . "'></img>";
                    } else {
                        $img = "No Image";
                    }
                    return  $img;
                })
                ->rawColumns(['operate', 'premium', 'quoted', 'image', 'section_name'])
                ->make(true);
        }
        // return view('categories',['sections'=>$sections]);
        return view('categories', compact('sections'));
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

        //
        if ($request->has('premium')) {
            //Checkbox checked
            $pre = 1;
        } else {
            $pre = 0;
        }
        if ($request->file('image') != null) {
            $files = $request->file('image');
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            //delete old file

            if ($request->hidden_image != null) {
                // dd($request->hidden_image);
                $ad = "categories/" . $request->hidden_image;
                // dd($ad);
                Storage::disk('public')->delete($ad);
            }
            // // File::delete('/storage/categories/'.$request->hidden_image);
            // //insert new file
            // // $newImgPath = "/storage/mood/".$newFile;
            // $destinationPath = '/storage/categories/'; // upload path
            $profileImage = "cat_" . date('YmdHis') . "." . $files->getClientOriginalExtension();
            // $files->move($destinationPath, $profileImage);
            Storage::putFileAs('public/categories', new File($files), $profileImage);
            $image = "$profileImage";
        } else {
            $image = $request->hidden_image;
        }
        // die($pre);
        if ($request->newSession != null) {
            $sections = Section::where('status',   0)->where('section_name', $request->section_id)->first();
            if ($sections) {
                $section_id = $sections->id;
            }
        } else {
            $section_id = $request->section_id;
        }
        Categories::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name, 'premium' => $pre, 'status' => '0',
                'image' => $image,
                'icon' => $request->icon,
                'section_id' => $section_id,
            ]
        );

        return response()->json(['success' => 'Category saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $category)
    {
        //
    }
    public function show_section(Request $request)
    {

        if ($request->has('q')) {
            $q = $request->q;
            $editData = Section::select("id", "textid", "section_name")->where([
                ["status", "=", "0"],
                ["section_name", "LIKE", "%$q%"]
            ])->orderBy('section_name', 'asc')->get();
        } elseif ($request->has('id')) {
            $editData = Section::select("id", "textid", "section_name")->where([
                ["status", "=", "0"],
                ["textid", "=", $request->id]
            ])->get();
        } else {
            $editData = Section::select("id", "textid", "section_name")->where('status', 0)->orderBy('section_name', 'asc')->get();
        }


        return response()->json($editData);
        // $sections = Section::where('status',   0)->get(['id', 'section_name AS text'])->toJson();
        // // dd($sections);
        // return $sections;
        // dd($sections);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Categories::where('textid', $id)->first();
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $page = Categories::where('textid', $id)->first();
        // Make sure you've got the Page model
        $quote_categories = QuotesCategories::where('categories_id', $page->id)->get();
        if ($quote_categories) {
            foreach ($quote_categories as $value) {
                # code...
                $value->status = '1';
                $value->save();
            }
        }
        if ($page) {
            $page->status = '1';
            $page->save();
        }
        return response()->json(['success' => 'Category deleted successfully.']);
    }
    public function reorder(Request $request)
    {
        foreach ($request->input('rows', []) as $row) {
            Categories::find($row['id'])->update([
                'row_order' => $row['position']
            ]);
        }
        return response()->noContent();
    }
}

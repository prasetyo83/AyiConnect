<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Models\Section;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dSection =  Section::where('status',   0)->get();
            return DataTables::of($dSection)
                ->editColumn('created_at', function ($dSection) {
                    return  date("d-M-Y h:i:sa", strtotime($dSection->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dSection) {
                    $btn = "<a class='btn btn-sm btn-primary edit-section' data-id='" . $dSection->textid . "' data-toggle='modal' data-target='#editSectionModal' title='Edit'><i class='fa fa-edit'></i></a>"."|"."<a class='btn btn-sm btn-danger delete-section' data-id='" . $dSection->textid . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                ->editColumn('premium', function ($dSection) {
                    $prem= ($dSection->premium== 1) ? "<a class='btn btn-sm btn-primary'> <i class='fa-solid fa-award'></i></a>": "<a class='btn btn-sm btn-danger'><i class='fa-solid fa-star-half'></i></a>";
                    return  $prem;
                })
                ->rawColumns(['operate','premium'])
                ->make(true);
        }
        return view('sections');
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
        if ($request->has('premium')) {
            //Checkbox checked
            $pre = 1;
        } else {
            $pre = 0;
        }
        // die($pre);
        Section::updateOrCreate(
            ['id' => $request->id],
            [
                'section_name' => $request->section_name, 'premium' => $pre, 'status' => '0'
            ]
        );
        return response()->json(['success' => 'Post saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Section::where('textid','=',$id)->first();
        // dd($post);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $page = Section::where ('textid','=',$id)->first();
        // Make sure you've got the Page model
        if ($page) {
            $page->status = '1';
            $page->save();
        }
        return response()->json(['success' => 'Post deleted successfully.']);
    }
    public function reorder(Request $request)
    {
        foreach($request->input('rows', []) as $row)
        {
            Section::find($row['id'])->update([
                'row_order' => $row['position']
            ]);
        }
        return response()->noContent();
    }
}

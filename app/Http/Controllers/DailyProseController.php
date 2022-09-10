<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\DailyProse;
use App\Models\Mood;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DailyProseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $authors = Author::where('delete', 0)->get();
        $moods = Mood::where('status', 0)->get();
        if ($request->ajax()) {
            $dDaylyprose =  DailyProse::where('status',   0)->get();
        //    dd($dDaylyprose);
            return DataTables::of($dDaylyprose)

                ->editColumn('created_at', function ($dDaylyprose) {
                    return  date("d-M-Y h:i:sa", strtotime($dDaylyprose->created_at));
                })
                ->editColumn('author', function ($dDaylyprose) {
                    $author = $dDaylyprose->author->name;
                    return  $author;
                })
                ->editColumn('mood', function ($dDaylyprose) {
                    $mood = $dDaylyprose->mood->title;
                    return  $mood;
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dDaylyprose) {

                    $btn = "<a class='btn btn-sm btn-primary edit-daily' data-id='" . $dDaylyprose->textid . "' data-toggle='modal' data-target='#editDailyModal' title='Edit'><i class='fa fa-edit'></i></a>" . "|" . "<a class='btn btn-sm btn-danger delete-daily' data-id='" . $dDaylyprose->textid . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })


                ->rawColumns(['operate'])
                ->make(true);
        }
        return view('daily-prose',compact('authors','moods'));
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

        DailyProse::updateOrCreate(
            ['id' => $request->id],
            [
                'mood_id' => $request->mood_id, 'author_id' => $request->author_id, 'status' => '0', 'prose' => $request->prose
            ]
        );
        return response()->json(['success' => 'Post saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DaylyProse  $daylyProse
     * @return \Illuminate\Http\Response
     */
    public function show(DailyProse $daylyProse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DaylyProse  $daylyProse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = DailyProse::where('textid', '=', $id)->first();
        // dd($post);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DaylyProse  $daylyProse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyProse $daylyProse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DaylyProse  $daylyProse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $page = DailyProse::where('textid', '=', $id)->first();
        // Make sure you've got the Page model
        if ($page) {
            $page->status = '1';
            $page->save();
        }
        return response()->json(['success' => 'Pose deleted successfully.']);
    }
}

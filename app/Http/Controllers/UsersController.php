<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Feeling;
use App\Models\Mood;
use App\Models\Mood_history;
use App\Models\Reason;
use App\Models\Users;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isNull;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dUsers =  Users::where('status',   0)->get();
            return DataTables::of($dUsers)
                ->editColumn('created_at', function ($dUsers) {
                    return  date("d-M-Y h:i:sa", strtotime($dUsers->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dUsers) {
                    $btn = "<a class='btn btn-sm btn-primary Mood' data-id='" . $dUsers->id . "' data-toggle='modal' data-target='#moodModal' title='Mood History'><i class='fa fa-info'></i></a>" . " " . "<a class='btn btn-sm btn-danger delete-Users' data-id='" . $dUsers->id . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                ->editColumn('gender', function ($dUsers) {
                    $gender = $dUsers->gender == "m" ? "Male" : "Female";

                    return  $gender;
                    // $prem= ($dUsers->premium== 1) ? "<a class='btn btn-sm btn-primary'> <i class='fa-solid fa-award'></i></a>": "<a class='btn btn-sm btn-danger'><i class='fa-solid fa-star-half'></i></a>";
                    // return  $prem;
                })
                ->editColumn('country', function ($dUsers) {
                     $countryName= "";
                    if ( $dUsers->country != null){
                        $resQCountry = Countries::where("country_code", "=", $dUsers->country)->first();                       
                        if($resQCountry){
                            $countryName = $resQCountry->country_name;
                        }                    
                    }

                    return  $countryName;
                    // $prem= ($dUsers->premium== 1) ? "<a class='btn btn-sm btn-primary'> <i class='fa-solid fa-award'></i></a>": "<a class='btn btn-sm btn-danger'><i class='fa-solid fa-star-half'></i></a>";
                    // return  $prem;
                })
                ->rawColumns(['operate', 'country'])
                ->make(true);
        }
        return view('users');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $response = '';
        if (!is_null($id)) {
            
            $all_mood_history = Mood_history::where('user_id', $id)->get();
            
            if (!$all_mood_history->isEmpty()) {
                // dd($all_mood_history);
                $response .= '<table class="table"><tr>';
                $response .= '<th>Mood</th>';
                $response .= '<th>Reason</th>';
                $response .= '<th>Feeling</th>';
                $response .= '<th>Date/Time</th></tr>';
                foreach ($all_mood_history as $data) {
                    $mood = Mood::where('id', $data->mood_id)->first();
                    $reason = Reason::where('id', $data->reason_id)->first();
                    $feeling = Feeling::where('id', $data->feeling_id)->first();

                    # code...
                    $response .= '<tr><td>' . $mood->title . '</td>';
                    $response .= '<td>' . $reason->title . '</td>';
                    $response .= '<td>' . $feeling->title . '</td>';
                    $response .= '<td>' . $data->created_at . '</td></tr>';
                }
                $response .= '</>';
            } else {
                // dd(
                //     "asd"
                // );
                $response = 'No data were found!';
            }
            return response()->json($response);
        }
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
        $page = Users::where('id', '=', $id)->first();
        // Make sure you've got the Page model
        if ($page) {
            $page->status = '1';
            $page->save();
        }
        return response()->json(['success' => 'Users deleted successfully.']);
    }
    
    public function export2csv(Request $request){
        $filename = "User_".date('d-m-Y').".csv";
        $users = Users::Where("status","0")->get();
        
        $headers= array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $columns = array('ID','Email','Name', 'Age', 'Gender', 'Country','Password','Token','Created Date');
        
        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                $row['ID']  = $user->id;
                $row['Email']    = $user->email;
                $row['Name']    = $user->name;
                $row['Age']  = $user->age;
                $row['Gender']  = $user->gender;
                $row['Country']  = $user->country;
                $row['Password']  = $user->password;
                $row['Token']  = $user->token;
                $row['Created Date']  = $user->created_at;

                fputcsv($file, array($row['ID'], $row['Email'], $row['Name'], $row['Age'], $row['Gender'], $row['Country'], $row['Password'], $row['Token'], $row['Created Date']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }
    
}

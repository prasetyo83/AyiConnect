<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class NewAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            
            $dUsers =  Admin::where('delete',   0)->get();
            return DataTables::of($dUsers)
                ->editColumn('created_at', function ($dUsers) {
                    return  date("d-M-Y h:i:sa", strtotime($dUsers->created_at));
                })
                ->addIndexColumn()
                ->addColumn('operate', function ($dUsers) {
                    $btn = "<a class='btn btn-sm btn-primary Mood' data-id='" . $dUsers->id . "' data-toggle='modal' data-target='#moodModal' title='2fa qr'><i class='fa fa-info'></i></a>" . " " . "<a class='btn btn-sm btn-danger delete-Users' data-id='" . $dUsers->id . "' title='Delete'><i class='fa fa-trash'></i></a>";
                    return $btn;
                })
                ->editColumn('isadmin', function ($dUsers) {
                    $isadmin = $dUsers->isadmin == "1" ? "Admin" : "Editor";

                    return  $isadmin;
                    // $prem= ($dUsers->premium== 1) ? "<a class='btn btn-sm btn-primary'> <i class='fa-solid fa-award'></i></a>": "<a class='btn btn-sm btn-danger'><i class='fa-solid fa-star-half'></i></a>";
                    // return  $prem;
                })

                ->rawColumns(['operate'])
                ->make(true);
        }
        return view('admins');
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
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
        // dd($id);
        $response = '';
        if (!is_null($id)) {
            
            $admins = Admin::where('id', $id)->get();
            $google2fa = app('pragmarx.google2fa');
            if (!$admins->isEmpty()) {
                // dd($admins);
                $response .= '<table class="table"><tr>';
                $response .= '<th>QRCode</th>';
                $response .= '<th>Secret</th>';
                
                foreach ($admins as $data) {
                    $QR_Image = $google2fa->getQRCodeInline(
                        config('app.name'),
                        $data['email'],
                        $data['google2fa_secret']
                    );

                    # code...
                    $response .= '<tr><td><div>' . $QR_Image . '</div></td>';
                    $response .= '<td>' . $data['google2fa_secret'] . '</td></tr>';
                    
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
        $page = Admin::where('id', '=', $id)->first();
        // Make sure you've got the Page model
        if ($page) {
            $page->delete = '1';
            $page->save();
        }
        return response()->json(['success' => 'Users deleted successfully.']);
    }

    public function register(Request $request)
    {
        //Validate the incoming request using the already included validator method
        $this->validator($request->all())->validate();

        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Save the registration data in an array
        $registration_data = $request->all();
        if ($request->has('isadmin')) {
            //Checkbox checked
            $registration_data["isadmin"]=1;
        } else {
            $registration_data["isadmin"]=0;
        }
        
        // Add the secret key to the registration data
        $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
        
        // Save the registration data to the user session for just the next request
        $request->session()->flash('registration_data', $registration_data);
        // dd($registration_data);
        // Generate the QR image. This is the image the user will scan with their app
     // to set up two factor authentication
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );
       // dd($QR_Image);

        // Pass the QR barcode image to our view
        // return view('register-admin', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);

        Admin::create([
            'username' => $registration_data['username'],
            'password' => Hash::make($registration_data['password']),
            'name' => $registration_data['name'],            
            'email' => $registration_data['email'],
            'company_name' => $registration_data['company_name'],
            'isadmin' => $registration_data['isadmin'],
            'google2fa_secret' => $registration_data['google2fa_secret'],
        ]);
        return redirect("admin");
    }
}

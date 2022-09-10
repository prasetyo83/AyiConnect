<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Settings;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $setting = Settings::where('type', 'system_configurations')->first();
        // dd($setting);
        return view('system', compact('setting'));
    }
    public function index_terms()
    {
        //
        $setting = Settings::where('type', 'policy_terms')->first();
        // if (!$setting)
        // {
        //     // dd("ass");
        //     $arr = array('type' => 'policy_terms', 'value' => '');
        //     $setting= json_encode($arr);
        //     // dd($setting);
        // }
        // dd($setting);
        return view('privacy', compact('setting'));
    }

    public function index_password()
    {
        //
        // $setting = Settings::where('type','policy_terms')->first();
        // if (!$setting)
        // {
        //     // dd("ass");
        //     $arr = array('type' => 'policy_terms', 'value' => '');
        //     $setting= json_encode($arr);
        //     // dd($setting);
        // }
        // dd($setting);
        return view('password');
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
        if ($request->dif == "system_configurations") {

            $value = [
                'app_version' => $request->app_version,
                'app_email' => $request->app_email,
                'app_description' => $request->app_description,
                'app_contact' => $request->app_contact,
                'app_author' => $request->app_author
            ];
            $value = json_encode($value);
            $count = Settings::where('type', 'system_configurations')->first();
            if ($count) {
                $count->update([
                    'value' => $value, 'type' => $request->dif
                ]);
            } else {
                Settings::create([
                    'value' => $value, 'type' => $request->dif
                ]);
            }
            return response()->json(['value' => $value]);
        } elseif ($request->dif == "policy_terms") {
            $value = [
                'app_policy' => $request->app_policy,
                'app_terms' => $request->app_terms,

            ];
            $value = json_encode($value);
            $count = Settings::where('type', 'policy_terms')->first();
            if ($count) {
                $count->update([
                    'value' => $value, 'type' => $request->dif
                ]);
            } else {
                Settings::create([
                    'value' => $value, 'type' => $request->dif
                ]);
            }
            return response()->json(['value' => $value]);
        } else {
            if (($request->old_password != null) && ($request->new_password == null)) {
                // dd($request->name);
                $useras = Admin::where('name', $request->name)->where('delete',0)->first();
                // dd($useras);
                $cek = Hash::check($request->old_password, $useras->password);
                if ($cek) {
                    
                    return response()->json([
                        'state' => 'success',
                        'data' => "<i class='far fa-check-circle fa-2x text-success'></i>",
                    ] );
                } else {
                    return response()->json([
                        'state' => 'fail',
                        'data' => "<i class='far fa-times-circle fa-2x text-danger'></i>",
                    ] );
                }
            } else {

                $user = Admin::where('name', $request->name)->where('delete',0)->first();
                $cek = Hash::check($request->old_password, $user->password);
                if ($cek) {
                    $password = Hash::make($request->new_password);
                    $user->password = $password;
                    $user->save();
                    return response()->json("Password has been change");
                } else {
                    return response()->json("old password doesn't match");
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW SETTINGS PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (!session('admin_logged_in')) {

            return redirect()->route('admin.login');

        }

        $setting = Setting::first();

        return view('settings', compact('setting'));
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE / UPDATE SETTINGS
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $request->validate([

            'upi_id' => [
                'required',
                'string',
                'max:100'
            ],

            'merchant_name' => [
                'required',
                'string',
                'max:100'
            ],

        ]);


        $setting = Setting::first();


        if (!$setting) {

            $setting = new Setting();

        }


        $setting->upi_id = $request->upi_id;

        $setting->merchant_name = $request->merchant_name;

        $setting->save();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT BACK TO DASHBOARD SETTINGS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.dashboard', ['page' => 'settings'])
            ->with(
                'success',
                'UPI Settings Saved Successfully!'
            );
    }
}
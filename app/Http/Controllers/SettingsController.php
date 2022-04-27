<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use File;

class SettingsController extends Controller
{
    //making auth middleware active for this router
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function addSettings(Request $request)
    {
        //making settings table empty
        $sdel = Settings::truncate();
        unlink(storage_path('public/Uploads/settingLogo/'));

        //storing new values
        $setting = new Settings;
        $setting->Company_Name = $request->Company_Name;
        $setting->Mobile_No = $request->Mobile_No;
        $setting->Email_Id = $request->Email_Id;
        $setting->Address = $request->Address;

        if ($files = $request->file('Logo')) {
            $file = $request->file('Logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = date('dmY') . uniqid() . '.' . $extension;
            $file->move('Uploads/settingLogo', $fileName);
            $setting->Logo = $fileName;
        }
        $setting->save();

        if($setting)
            return redirect()->back()->with('status','Company Details Added Successfully');
    }
}

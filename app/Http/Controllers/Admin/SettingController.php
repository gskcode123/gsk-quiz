<?php

namespace App\Http\Controllers\Admin;

use App\Model\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /*
    * generalSetting
    *
    * general Setting
    *
    *
    *
    *
    */

    public function generalSetting()
    {
        $data['pageTitle'] = __('General Setting');
        $data['adm_setting'] = allsetting();

        return view('admin.setting.general-setting', $data);
    }

    /*
    * saveSettings
    *
    * save admin setting data
    *
    *
    *
    *
    */

    public function saveSettings(Request $request)
    {
        try {
            if (isset($request->company_name)) {
                AdminSetting::where(['slug' => 'company_name'])->update(['value' => $request->company_name]);
            }
            if (isset($request->lang)) {
                AdminSetting::where(['slug' => 'lang'])->update(['value' => $request->lang]);
            }
            if (isset($request->app_title)) {
                AdminSetting::where(['slug' => 'app_title'])->update(['value' => $request->app_title]);
            }
            if (isset($request->primary_email)) {
                AdminSetting::where(['slug' => 'primary_email'])->update(['value' => $request->primary_email]);
            }
            if (isset($request->copyright_text)) {
                AdminSetting::where(['slug' => 'copyright_text'])->update(['value' => $request->copyright_text]);
            }
            if (isset($request->logo)) {
                AdminSetting::updateOrCreate(['slug' => 'logo'], ['value' => uploadthumb($request->logo, path_image(), 'logo_', '', '', allsetting()['logo'])]);
            }
            if (isset($request->favicon)) {
                AdminSetting::updateOrCreate(['slug' => 'favicon'], ['value' => uploadthumb($request->favicon, path_image(), 'favicon_', '', '', allsetting()['favicon'])]);
            }
            if (isset($request->login_logo)) {
                AdminSetting::updateOrCreate(['slug' => 'login_logo'], ['value' => uploadthumb($request->login_logo, path_image(), 'login_', '', '', allsetting()['login_logo'])]);
            }

            return redirect()->back()->with(['success' => __('Updated Successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['dismiss' => 'Opsss! Something wrong please try again']);
        }
    }

}

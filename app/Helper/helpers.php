<?php

use App\Model\AdminSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

function allsetting($a = null)
{
    if ($a == null) {
        $allsettings = AdminSetting::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = AdminSetting::where(['slug' => $a])->first();
        if ($allsettings) {
            $output = $allsettings->value;
            return $output;
        }
        return false;
    }
}
//Random string
function randomString($a)
{
    $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}
// random number
function randomNumber($a = 10)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}
//use array key for validator
function arrKeyOnly($array, $seperator = ',', $exception = [])
{
    $string = '';
    $sep = '';
    foreach ($array as $key => $val) {
        if (in_array($key, $exception) == false) {
            $string .= $sep . $key;
            $sep = $seperator;
        }
    }
    return $string;
}
function uploadimage($img,$path,$user_file_name=null,$width=null,$height=null)
{
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (isset($user_file_name) && $user_file_name != "" && file_exists( $path.$user_file_name)) {
        unlink($path.$user_file_name);
    }
    // saving image in target path
    $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
    $imgPath = public_path($path.$imgName);
    // making image
    $makeImg = Image::make($img);
    if($width!=null && $height!=null && is_int($width) && is_int($height))
    {
        // $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if($makeImg->save($imgPath))
    {
        return $imgName;
    }
    return false;
}

function fileUpload($new_file, $path, $old_file_name = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {
        unlink($path . '/' . $old_file_name);
    }
    $input['imagename'] = time() . '.' . $new_file->getClientOriginalExtension();
    $destinationPath = public_path($path);
    $new_file->move($destinationPath, $input['imagename']);

    return $input['imagename'];
}

//Image Thumb Upload System
function uploadthumb($img, $path, $name, $width = null, $height = null, $old_file_name = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0755, true);
    }
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {
        unlink($path . $old_file_name);
    }
    $imgName = $name . $img->getClientOriginalName();
    $imgPath = public_path($path . $imgName);

    // making image
    $makeImg = Image::make($img);
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}

function pathUserImage()
{
    return 'uploaded_file/files/userimg/';
}

function removeImage($path, $file_name)
{
    if (isset($file_name) && $file_name != "" && file_exists($path . $file_name)) {
        unlink($path . $file_name);
    }
}
//Advertisement image path
function path_image()
{
    return 'uploaded_file/files/img/';
}
function path_category_image()
{
    return 'uploaded_file/files/img/category/';
}
function path_landing_team_image()
{
    return 'uploaded_file/files/img/landing/team/';
}
function path_landing_blog_image()
{
    return 'uploaded_file/files/img/landing/blog/';
}

function language()
{
    $lang = [];
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $langName = basename($file, '.json');
        $lang[$langName] = $langName;
    }
    return empty($lang) ? false : $lang;
}
function langName($input=null){
    $output = [
        'en' => 'English',
        'pt-PT' => 'Português(Portugal)',
        'es' => 'Español',
        'ja' => '日本人',
        'zh' => '中文',
        'ko' => '한국어',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
if (!function_exists('settings')) {

    function settings($keys = null)
    {
        if ($keys && is_array($keys)) {
            return Adminsetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
        } elseif ($keys && is_string($keys)) {
            $setting = Adminsetting::where('slug', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return Adminsetting::pluck('value', 'slug')->toArray();
    }
}
function set_lang($lang)
{
    $lang = strtolower($lang);
    $languages = language();
    if (in_array($lang, $languages)) {
        app()->setLocale($lang);
    } else {
        if (Auth::check() && (Auth::user()->role==USER_ROLE_ADMIN) && isset(allsetting()['lang'])) {
            $lang = allsetting()['lang'];
            app()->setLocale($lang);
        }
        elseif(Auth::check() && (Auth::user()->role==USER_ROLE_USER) && isset(Auth::user()->user_settings->language)) {
            $lang = Auth::user()->user_settings->language;
            app()->setLocale($lang);
        }
    }
}

if (!function_exists('role')) {
    function role($val = null)
    {
        $myrole = array(
            1 => __('Admin'),
            2 => __('User')
        );
        if ($val == null) {
            return $myrole;
        } else {
            return $myrole[$val];
        }
        return $myrole;
    }
}
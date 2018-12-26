<?php

use App\Model\AdminSetting;
use App\Model\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

function checkRolePermission($role_task, $my_role)
{

    $role = Role::findOrFail($my_role);
    if (!empty($role->actions)) {
        if (!empty($role->actions)) {
            $tasks = array_filter(explode('|', $role->actions));
        }
        if (isset($tasks)) {
            if (in_array($role_task, $tasks) && array_key_exists($role_task, actions())) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    return 0;
}
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
function path_landing_image()
{
    return 'uploaded_file/files/img/landing/';
}
function path_landing_team_image()
{
    return 'uploaded_file/files/img/landing/team/';
}
function path_landing_blog_image()
{
    return 'uploaded_file/files/img/landing/blog/';
}
// Convert currency
function convertCurrency($amount, $to = 'USD', $from = 'USD')
{
    try{
        $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
        $json = file_get_contents($url); //,FALSE,$ctx);
        $jsondata = json_decode($json, TRUE);
        return $amount * $jsondata[$to];
    }catch(\Exception $e){
        return $amount*allsetting()['coin_price'];
    }
}
//function for getting client ip address
function get_clientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
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
//Call this in every function
//function set_lang($lang)
//{
//    $default = settings('lang');
//    $lang = strtolower($lang);
//    $languages = language();
//    if (in_array($lang, $languages)) {
//        app()->setLocale($lang);
//    } else {
//        if (isset($default)) {
//            $lang = $default;
//            app()->setLocale($lang);
//        }
//    }
//}
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
//find odd even
function oddEven($number){
//    dd($number);
    if ($number % 2 == 0) {
        return 'even';
    }else{
        return 'odd';
    }
}
function convert_currency($amount, $to = 'USD', $from = 'USD')
{
    $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
    $json = file_get_contents($url); //,FALSE,$ctx);
    $jsondata = json_decode($json, TRUE);
    return bcmul($amount,$jsondata[$to]);
}
// fees calculation
function calculate_fees($amount, $method)
{
    $settings = allsetting();
    try {
        if ($method == SEND_FEES_FIXED) {
            return $settings['send_fees_fixed'];
        } elseif ($method == SEND_FEES_PERCENTAGE) {
            return ($settings['send_fees_percentage'] * $amount) / 100;
        } elseif ($method == SEND_FEES_BOTH) {
            return $settings['send_fees_fixed'] + (($settings['send_fees_percentage'] * $amount) / 100);
        } else {
            return 0;
        }
    } catch (\Exception $e) {
        return 0;
    }
}
// replace or add language text
function replace_or_add_lang($new_key,$old_key=null){
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $langName = basename($file, '.json');
        try{
            $content = json_decode(file_get_contents($file), true);
            if(isset($old_key) && isset($content[$old_key])){
             unset($content[$old_key]);
            }
            $content[$new_key['en']]=$new_key[$langName];
            $newJsonString = json_encode($content, JSON_PRETTY_PRINT);
            file_put_contents($file, $newJsonString);
        }catch(\Exception $e){

        }
    }
    return true;
}
function remove_text_from_lang_json($old_key){
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        try{
            $content = json_decode(file_get_contents($file), true);
            foreach ($old_key as $ok){
                if(isset($content[$ok])){
                    unset($content[$ok]);
                    $newJsonString = json_encode($content, JSON_PRETTY_PRINT);
                    file_put_contents($file, $newJsonString);
                }
            }

        }catch(\Exception $e){}
    }
    return true;
}
function get_translation($language,$text){
    $path = base_path('resources/lang/').$language.'.json';
    $content = json_decode(file_get_contents($path), true);
    if(isset($content[$text])){
        return $content[$text];
    }
    return '';
}

if (!function_exists('custom_number_format'))
{
    function custom_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 8, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 14, '.', ''));
        return $number[0] . '.' . substr($number[1], 0, 8);
    }
}

if (!function_exists('visual_number_format'))
{
    function visual_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 2, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 14, '.', ''));
        $intVal = (int)$value;
        if ($value > $intVal || $value < 0) {
            $intPart = $number[0];
            $floatPart = substr($number[1], 0, 8);
            $floatPart = rtrim($floatPart, '0');
            if (strlen($floatPart) < 2) {
                $floatPart = substr($number[1], 0, 2);
            }
            return $intPart . '.' . $floatPart;
        }
        return $number[0] . '.' . substr($number[1], 0, 2);
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

if (!function_exists('max_level')) {
    function max_level()
    {
        $max_level = allsetting('max_affiliation_level');

        return $max_level ? $max_level : 3;
    }

}
if (!function_exists('user_balance')) {
    function user_balance($userId)
    {
        $balance = Wallet::where('user_id', $userId)->sum(DB::raw('balance + referral_balance'));

        return $balance ? $balance : 0;
    }

}
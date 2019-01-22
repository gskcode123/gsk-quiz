<?php

use App\Model\AdminSetting;
use App\Model\Question;
use App\Model\QuestionOption;
use App\Model\UserAnswer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
function path_question_image()
{
    return 'uploaded_file/files/img/question/';
}
function path_question_option_image()
{
    return 'uploaded_file/files/img/question/options/';
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
if (!function_exists('question_type')) {
    function question_type($val = null)
    {
        $data = array(
            1 => __('Multiple Choise'),
            2 => __('Puzzle'),
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}
if (!function_exists('active_statuses')) {
    function active_statuses($val = null)
    {
        $data = array(
            1 => __('Active'),
            0 => __('Inactive'),
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

if (!function_exists('count_question')) {
    function count_question($cat_id)
    {
        $qs = 0;
        $qs = Question::where(['status' => 1, 'category_id' => $cat_id])->count();

        return $qs;
    }
}

if (!function_exists('answers')) {
    function answers($question_id)
    {
        $ans = '';
        $answer = QuestionOption::where(['is_answer' => 1, 'question_id' => $question_id])->orderBy('id', 'ASC')->first();
        if (isset($answer)) {
            $ans = $answer->option_title;
        }
        return $ans;
    }
}

if (!function_exists('calculate_ranking')) {
    function calculate_ranking($user_id)
    {
        $scores = UserAnswer::select(
            DB::raw('user_id, SUM(point) as score'))
            ->groupBy('user_id')
            ->orderBy('score', 'DESC')
            ->get();
        if(isset($scores)) {
            foreach ($scores as $score) {
                $items[] = [
                    'user_id' => $score->user_id,
                    'score' => $score->score
                ];
            }
            $ranking = array_search($user_id, array_column($items, 'user_id'));
//dd($ranking);
            if($ranking === false) {
                $ranking= 0;
            } else {
                $ranking = $ranking+1;;
            }
        } else {
            $ranking = 0;
        }

        return $ranking;
    }
}

if (!function_exists('calculate_score')) {
    function calculate_score($user_id)
    {
        $score = 0;
        $scores = UserAnswer::select(
            DB::raw('SUM(point) as score'))
            ->where('user_id',$user_id)
            ->first();
        if(isset($scores)) {
            if ($scores->score > 0) {
                $score = $scores->score;
            } else {
                $score = 0;
            }
        } else {
            $score = 0;
        }

        return $score;
    }
}

//google firebase
function pushNotification($registrationIds,$type, $data_id, $count)
{
    $cat = \App\Model\Category::find($data_id);
    $fields = array
    (
        'to' => $registrationIds,
        "delay_while_idle" => true,
        "time_to_live" => 3,
        /*    'notification' => [
                'body' => strip_tags(str_limit($news->description,30)),
                'title' => str_limit($news->title,25),
            ],*/
        'data'=> [
//            'message' => strip_tags(str_limit($news->description,30)),
            'name' => $cat->name,
            'id' => $cat->id,
            'is_background' => true,
            'content_available'=>true,
        ]
    );


    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $fields;

}

//google firebase
function pushNotificationIos($registrationIds,$type, $data_id, $count)
{

    $news = \App\News::find($data_id);

    $fields = array
    (
        'to' => $registrationIds,
        "delay_while_idle" => true,

        "time_to_live" => 3,
        'notification' => [
            'body' => strip_tags(str_limit($news->description,30)),
            'title' => str_limit($news->title,25),
            'vibrate' => 1,
            'sound' => 'default',
        ],
        'data'=> [
            'message' => strip_tags(str_limit($news->description,30)),
            'title' => str_limit($news->title,25),
            'id' => $news->id,
            'is_background' => true,
            'content_available'=>true,


        ]
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $fields;

}


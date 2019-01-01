<?php

namespace App\Http\Controllers\Api;

use App\Model\UserAnswer;
use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /*
     * profileUpdate
     *
     * Update my profile
     *
     *
     *
     *
     */

    public function profile()
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
        }
        $data = ['success' => false, 'data' => [], 'message' => __('Invalid User')];
        if (isset(Auth::user()->id)) {
            $user = User::select(
                'id',
                'name',
                'email',
                'country',
                'phone',
                'photo',
                'active_status',
                'role',
                'email_verified',
                'reset_code',
                'language',
                'city',
                'state',
                'zip',
                'address',
                'created_at',
                'updated_at'
            )->findOrFail(Auth::user()->id);

            $data['data']['user'] = $user;
            $data['data']['user']->photo = asset(pathUserImage() . $user->photo);
            $data['data']['user']['ranking'] = calculate_ranking($user->id);
            $data['data']['user']['points'] = calculate_score($user->id);
            $data['success'] = true;
            $data['message'] = __('Successfull');
        }
        return response()->json($data);
    }

    /*
     * profileUpdate
     *
     * Update my profile
     *
     *
     *
     *
     */
    public function profileUpdate(Request $request)
    {
        $data = ['success' => false, 'message' => __('Something Went wrong.')];
        $rules=[
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'The Name field can not empty'
        ];
        if (!empty($request->photo)) {
            $rules['photo'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:20000';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $userRepository = app(UserRepository::class);
        $response = $userRepository->profileUpdate($request->all(),Auth::user()->id);
        if ($response['status'] == false) {
            $data['success'] = $response['status'];
            $data['message'] = $response['message'];
        } else {
            $data['success'] = $response['status'];
            $data['message'] = $response['message'];
        }

        return response()->json($data);
    }

    /*
     * changePassword
     *
     * Password change process
     *
     *
     *
     *
     */

    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ];
        $messages = [
            'password_confirmation.confirmed' => 'The password confirmation does not match.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $userRepository = app(UserRepository::class);
        $response = $userRepository->passwordChange($request->all(), Auth::user()->id);

        $data['response'] = $response;

        return response()->json($data);
    }

    /*
     * userSetting
     *
     * user general Setting
     *
     *
     *
     *
     */

    public function userSetting()
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Invalid User')];
        if(!empty(language())) {
            foreach (language() as $val) {
                $item[] = [
                    'key' =>$val,
                    'value'=>langName($val)
                ];
            }
            if(!empty($item)) {
                $data['data']['lang'] = $item;
            }
        }
        if (isset(Auth::user()->id)) {
            $user = User::select('id', 'language')->findOrFail(Auth::user()->id);
            $data['data']['user'] = $user;
            $data['success'] = true;
            $data['message'] = __('Successfull');
        }
        return response()->json($data);
    }

    public function saveUserSetting(Request $request)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Invalid User')];
        $rules = [
            'language' => 'required',
        ];
        $messages = [
            'language.required' => 'Must be select a Language'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $user = User::where('id',Auth::user()->id)->first();
        if (isset($request->language)) {
            $input['language'] = $request->language;
        }
        if (isset($user)) {
            $user->update($input);
            $data =[
                'success' => true,
                'message' => __('Save Setting Successfully')
            ];
        }

        return response()->json($data);
    }
}

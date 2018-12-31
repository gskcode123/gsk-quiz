<?php

namespace App\Http\Controllers\Api;

use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            )
                ->findOrFail(Auth::user()->id);
            $data['data']['user'] = $user;
            $data['data']['user']->photo = asset(pathUserImage() . $user->photo);
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
}

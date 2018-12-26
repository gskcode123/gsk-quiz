<?php

namespace App\Http\Controllers;

use App\Services\CommonService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /*
     * userSignUp
     *
     * User Sign up page
     *
     *
     *
     */

    public function userSignUp()
    {
        $data['pageTitle'] = __('Registration');
        return view('Auth.signup', $data);
    }

    /*
     * userSave
     *
     * User Sign up process
     *
     *
     *
     */

    public function userSave(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|strong_pass|confirmed',
                'password_confirmation' => 'required',
            ];

            $messages = [
                'first_name.required' => __('First Name field can not be empty'),
                'last_name.required' => __('Last Name field can not be empty'),
                'password.required' => __('Password field can not be empty'),
                'password_confirmation.required' => __('Password confirmed field can not be empty'),
                'password.min' => __('Password length must be above 8 characters.'),
                'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!'),
                'email.required' => __('Email field can not be empty'),
                'email.unique' => __('Email Address already exists'),
                'email.email' => __('Invalid email address'),
            ];

            $this->validate($request, $rules,$messages);
            //verification key s for email and phone

            $mail_key = $this->generate_email_verification_key();
            $mailTemplet = 'email.verify';

            $response = app(CommonService::class)->userRegistration($request, $mailTemplet, $mail_key);
            if (isset($response['success']) && $response['success']) {
                return redirect()->route('login')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('error', $response['message']);
        }
        return redirect()->back();
    }

    /*
     * generate_email_verification_key
     *
     * Generate email verification key
     *
     *
     *
     */

    private function generate_email_verification_key()
    {
        do {
            $key = Str::random(60);
        } While (User::where('email_verified', $key)->count() > 0);

        return $key;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Model\UserVerificationCode;
use App\Services\MailService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use IssueTokenTrait;

    /*
     * postLogin
     *
     * User Login process
     *
     *
     *
     */
    public function postLogin(Request $request)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something Went wrong !')];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors;

            return response()->json($data);
        }

        $user = User::where('email', $request->email)->first();

        if (isset($user) && Hash::check($request->password, $user->password)) {

            $token = $user->createToken($request->email)->accessToken;
            //Check email verification
            if ($user->active_status == STATUS_SUCCESS) {
                if ($user->email_verified == STATUS_SUCCESS) {
                    $user->update();

                    $data['success'] = true;
                    $data['data'] = ['access_token' => $token, 'access_type' => "Bearer"];
                    $data['message'] = __('Successfully Logged in');

                } else {
                    $mail_key = randomNumber(6);
                    $mailService = app(MailService::class);
                    UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'type' => 1, 'status' => STATUS_PENDING, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);
                    $userName = $user->name;
                    $userEmail = $user->email;
                    $companyName = isset($default['company']) && !empty($default['company']) ? $default['company'] : __('Quiz Test');
                    $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
                    $data['data'] = $user;
                    $data['key'] = $mail_key;

                    $mailService->send('email.verifyapp', $data, $userEmail, $userName, $subject);

                    $data['success'] = true;
                    $data['data'] = ['access_token' => $token, 'access_type' => "Bearer"];
                    $data['message'] = __('Your email is not verified. Please verify your email to get full access.');
                }
            } elseif ($user->active_status == STATUS_SUSPENDED) {
                $data['success'] = false;
                $data['message'] = __("Your Account has been suspended. please contact support team to active again");
            } elseif ($user->active_status == STATUS_DELETED) {
                $data['success'] = false;
                $data['message'] = __("Your Account has been deleted. please contact support team to active again");
            } elseif ($user->active_status == STATUS_PENDING) {
                $data['success'] = false;
                $data['message'] = __("Your Account has been Pending for admin approval. please contact support team to active again");
            }

        } else {
            $data['success'] = false;
            $data['message'] = __("Email or Password doesn't match");
        }

        return response()->json($data);
    }

    /*
     * postRegistration
     *
     * User Registration process
     *
     *
     *
     */

    public function postRegistration(Request $request)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something Went wrong !')];
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|strong_pass|confirmed',
            'password_confirmation' => 'required',
        ];
        if ($request->phone) {
            $rules['phone'] = 'numeric|phone_number';
        }
        $messages = [
            'name.required' => __('Name field can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be above 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!'),
            'email.required' => __('Email field can not be empty'),
            'email.unique' => __('Email Address already exists'),
            'email.email' => __('Invalid email address'),
            'phone.phone_number' => __('Invalid Phone Number'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }

            $data['message'] = $errors;
            return response()->json($data);
        }

        //verification key s for email and phone
        $mail_key = $this->generate_email_verification_key();

        $user = User::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => USER_ROLE_USER,
            'active_status' => STATUS_SUCCESS,
            'email_verified' => STATUS_PENDING,
            'reset_code' => md5($request->get('email') . uniqid() . randomString(5)),
        ]);

        UserVerificationCode::create([
            'user_id' => $user->id,
            'code' => $mail_key,
            'type' => 1,
            'status' => STATUS_PENDING,
            'expired_at' => date('Y-m-d', strtotime('+10 days'))
        ]);
        $mailService = app(MailService::class);
        $userName = $user->name ;
        $userEmail = $user->email;
        $companyName = isset($default['company']) && !empty($default['company']) ? $default['company'] : __('Quiz Test');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send('email.verifyapp', $data, $userEmail, $userName, $subject);

        if ($user) {
            $token = $user->createToken($request->get('email'))->accessToken;
            $data['success'] = true;
            $data['data'] = ['access_token' => $token, 'access_type' => "Bearer", 'user_info' => $user];
            $data['message'] = __('Successfully Signed up! Please verify your acccount');

            return response()->json($data);
        }

        throw new ApiException(__('Registration failed. Please try again.'));
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
        $key = randomNumber(6);
        return $key;
    }

    /*
     * sendToken
     *
     * Send code to email for changing forget password
     *
     *
     *
     */

    public function sendToken(Request $request)
    {
        $rules = ['email' => 'required|email'];
        $messages = ['email.required' => __('Email field can not be empty'), 'email.email' => __('Email is invalid')];

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

        $user = User::where(['email' => $request->email])->first();

        if ($user) {
            $token = randomNumber(6);
            UserVerificationCode::create([
                'user_id' => $user->id,
                'type' => 1,
                'code' => $token,
                'expired_at' => date('Y-m-d', strtotime('+10 days')),
                'status' => STATUS_PENDING
            ]);
            $user_data = [
                'email' => $user->email,
                'name' => $user->name,
                'token' => $token,
            ];
            try {
                Mail::send('email.password_reset', $user_data, function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject('Forgot Password');
                });
            } catch (\Exception $e) {
                $response = [
                    'message' => $e->getMessage()
                ];

                return response()->json($response);
            }
            $response = [
                'message' => 'Mail sent Successfully to ' . $user->email . ' with Password reset Code.',
                'success' => true
            ];

        } else {
            $response = [
                'message' => __('Sorry! The email could not be found'),
                'success' => false
            ];
        }
        return response()->json($response);
    }

    /*
     * resetPassword
     *
     * Reset password process
     *
     *
     *
     */

    public function resetPassword(Request $request)
    {
        $rules = [
            'access_code' => 'required|max:256',
            'password' => 'required|min:8|strong_pass|confirmed',
            'password_confirmation' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = [
                'success' => false,
                'message' => $errors
            ];

            return response()->json($response);
        } else {
            $vf_code = UserVerificationCode::where(['type' => 1, 'code' => $request->access_code])->first();

            if (isset($vf_code)) {
                User::where(['id' => $vf_code->user_id])->update(['password' => bcrypt($request->password)]);
                UserVerificationCode::where(['id' => $vf_code->id])->update(['status' => STATUS_SUCCESS]);
                $data['success'] = true;
                $data['message'] = __('Password Reset Successfully');
            } else {
                $data['success'] = false;
                $data['message'] = __('Reset Code not valid.');
            }
            return response()->json($data);
        }
    }
}

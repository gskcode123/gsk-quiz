<?php

namespace App\Services;

use App\Model\AffiliationCode;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\UserInfo;
use App\Model\UserSetting;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Model\WalletAddress;
use App\Model\Withdrawal;
use App\Repository\AffiliateRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CommonService
{
    protected $logger;

    public function __construct()
    {
        $this->logger = app(Logger::class);
    }

    // User
    public function sendSmsVerificationCode()
    {
        $randno = randomNumber(6);
        $smsText = 'Your '.allsetting()['app_title'].' verification code is here ' . $randno;
        app(SmsService::class)->send(Auth::user()->phone, $smsText);
        $update = User::where(['id' => Auth::user()->id])->update(['phone_verification' => $randno]);
        if (!$update) {
            return [
                'success' => false,
                'message' => __('Failed to send Sms!'),
            ];
        }

        return [
            'success' => true,
            'message' => __('Sms sent successfully!'),
        ];
    }

    /*Phone verification check*/
    public function phonesecurity($request)
    {
        $sms_ver_code = UserVerificationCode::where(['code' => $request->phone_verification, 'status' => STATUS_PENDING, 'type' => 2])
            ->where('expired_at', '>=', date('Y-m-d'))->first();
        if (isset($sms_ver_code)) {
            UserVerificationCode::where('id', $sms_ver_code->id)->update(['status' => STATUS_SUCCESS]);
            User::where(['id' => $sms_ver_code->user_id])->update(['phone_verified' => STATUS_SUCCESS]);
        } else {
            return [
                'success' => false,
                'message' => __("Code doesn't match!"),
            ];
        }

        return [
            'success' => true,
            'message' => __("Phone verified successfully."),
        ];
    }

    /*Email Verification check*/
    public function emailcurity($request)
    {
        $sms_ver_code = UserVerificationCode::where(['code' => $request->email_verification, 'status' => STATUS_PENDING, 'type' => 1])
            ->where('expired_at', '>=', date('Y-m-d'))->first();
        if (isset($sms_ver_code)) {
            UserVerificationCode::where('id', $sms_ver_code->id)->update(['status' => STATUS_SUCCESS]);
            User::where(['id' => $sms_ver_code->user_id])->update(['email_verified' => STATUS_SUCCESS]);
        } else {
            return ['success' => false, 'message' => __("Code doesn't match!"),];
        }
        return ['success' => true, 'message' => __("Email verified successfully.")];
    }

    public function save_setting($request)
    {

        if (!is_null($request->phone)) {
            $rules['phone'] = 'numeric|required|regex:/[0-9]{10}/|phone_number|unique:users,phone,' . Auth::user()->id;
        }else{
            $data = ['success' => false, 'data' => ['is_phone_updated' => false], 'message' => __('Something Went Wrong.')];
            $rules = ['first_name' => 'required|max:256', 'last_name' => 'required|max:256'];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors;
            return $data;
        }
        $user = User::where(['id' => Auth::user()->id]);

        if(empty($request->phone)){
            $firstName = $request->first_name;
            $lastName = $request->last_name;
            $update ['first_name'] = $firstName;
            $update ['last_name'] = $lastName;
            $data['update_type']='profile';
        }else{

            $code = $request->code;
            $phone = $request->phone;
            $phone_marge = $request->code . $request->phone;
            $update ['country_code'] = $code;
            $update ['phone'] = $phone;
            if ($user->first()->phone != $phone) {
                if (!is_null($phone)) {
                    $randno = randomNumber(6);
                    $smsText = 'Your '.allsetting()['app_title'].' verification code is here ' . $randno;
                    $sendSms = app(SmsService::class)->send($phone_marge, $smsText);
                    if (!$sendSms) {
                        $data['success'] = false;
                        $data['data']['is_phone_updated'] = false;
                        $data['message'] = __('Failed to send verification code');
                    }
                    if (!is_null($request->phone)) {
                        User::where(['id' => Auth::user()->id])->update(['phone_verified' => STATUS_PENDING]);
                        UserVerificationCode::create(['user_id' => Auth::user()->id, 'type' => 2, 'code' => $randno, 'expired_at' => date('Y-m-d', strtotime('+15 days')), 'status' => STATUS_PENDING]);

                        $data['data']['is_phone_updated'] = true;
                    }
                }
                $update ['phone'] = $phone;
            }
            $data['update_type']='phone';
        }

        if ($user->update($update)) {
            $data['success'] = true;
            $data['message'] = __('Information Updated Successfully');
        }

        return $data;
    }

    public function save_login_setting($request)
    {
        $rules = [
            'password' => 'required|min:8|strong_pass|confirmed',
        ];

        $messages = [
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be above 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!')
        ];

        $request->validate($rules, $messages);
        $password = $request->password;

        $update ['password'] = Hash::make($password);

        $user = User::where(['id' => Auth::user()->id]);

        if ($user->update($update)) {
            return [
                'success' => true,
                'message' => 'Information Updated Successfully'
            ];
        }

        return [
            'success' => false,
            'message' => 'Information Update Failed. Try Again!'
        ];
    }

    public function getQRCodeGoogleUrl($address, $title = null, $params = array())
    {
        $width = !empty($params['width']) && (int)$params['width'] > 0 ? (int)$params['width'] : 210;
        $height = !empty($params['height']) && (int)$params['height'] > 0 ? (int)$params['height'] : 204;
        $level = !empty($params['level']) && array_search($params['level'], array('L', 'M', 'Q', 'H')) !== false ? $params['level'] : 'M';

        $urlencoded = $address;
        return 'https://chart.googleapis.com/chart?chs=' . $width . 'x' . $height . '&chld=' . $level . '|0&cht=qr&chl=' . $urlencoded . '';
    }

    public function isPhoneVerified($user)
    {
        if (empty($user->phone) || $user->phone_verified == PHONE_IS_NOT_VERIFIED) {
            return ['success' => false, 'phone_verify' => false, 'message' => __('Please Verify your phone.')];
        }else{
            return ['success' => true, 'phone_verify' => true, 'message' => __('Verified phone.')];
        }
    }

    public function userRegistration($request, $mailTemplet, $mail_key)
    {
        $randno = randomNumber(6);
        try {
            DB::transaction(function () use ($request, $mailTemplet, $mail_key, $randno) {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => isset($request->role) ? $request->role : USER_ROLE_USER,
                    'active_status' => STATUS_SUCCESS,
                    'email_verified' => STATUS_PENDING,
                    'reset_code' => md5($request->get('email') . uniqid() . randomString(5)),
                ]);
                UserVerificationCode::create(
                    ['user_id' => $user->id,
                        'type' => 1,
                        'code' => $mail_key,
                        'expired_at' => date('Y-m-d', strtotime('+10 days')),
                        'status' => STATUS_PENDING]
                );

                $this->sendVerificationMail($user, $mailTemplet, $mail_key);
            });
            return [
                'success' => true,
                'message' => __('We have just sent a verification link on Email . ')
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('Something went wrong . Please try again!')
            ];
        }
    }


    public function sendVerificationMail($user, $mailTemplet, $mail_key)
    {

        $mailService = app(MailService::class);
        $userName = $user->first_name. ' '.$user->last_name;
        $userEmail = $user->email;
        $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Coin Wallet');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send($mailTemplet, $data, $userEmail, $userName, $subject);
    }

    public function user_details($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    private function sendVerificationSms($phone, $randno)
    {
        $smsText = 'Your '.allsetting()['app_title'].' verification code is here ' . $randno;
        app(SmsService::class)->send($phone, $smsText);
    }

}

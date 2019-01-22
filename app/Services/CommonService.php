<?php

namespace App\Services;

use App\Model\AffiliationCode;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\UserCoin;
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
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => isset($request->role) ? $request->role : USER_ROLE_USER,
                    'active_status' => STATUS_SUCCESS,
                    'email_verified' => STATUS_PENDING,
                    'reset_code' => md5($request->get('email') . uniqid() . randomString(5)),
                    'language' => 'en'
                ]);
                UserVerificationCode::create(
                    ['user_id' => $user->id,
                        'type' => 1,
                        'code' => $mail_key,
                        'expired_at' => date('Y-m-d', strtotime('+10 days')),
                        'status' => STATUS_PENDING]
                );
                $this->create_coin_wallet($user->id);
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
        $userName = $user->name;
        $userEmail = $user->email;
        $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Coin Wallet');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send($mailTemplet, $data, $userEmail, $userName, $subject);
    }

    public function create_coin_wallet($user_id)
    {
        $coin = 0;
        if(!empty(allsetting('signup_coin'))) {
            $coin = allsetting('signup_coin');
        }
        $createCoinWallet = UserCoin::create(['user_id' => $user_id, 'coin' => $coin]);
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

    public function addOrDeductCoin($coin, $type)
    {
        $response['status'] = false;
        $response['message'] = __('Invalid Request');

        try {
            $userCoin = UserCoin::where('user_id', Auth::user()->id)->first();
            $response['available_coin'] = 0;
            if (isset($userCoin)) {
                $response['available_coin'] = $userCoin->coin;
                if ($type == 1) {
                    if ($userCoin->coin < $coin) {
                        $response['status'] = false;
                        $response['message'] = __("You don't have sufficient coin");
                    } else {
                        $deductCoin = bcsub($userCoin->coin, $coin);
                        $dCoin = $userCoin->update(['coin' => $deductCoin]);
                        if ($dCoin) {
                            $response['status'] = true;
                            $response['available_coin'] = UserCoin::where('user_id', Auth::user()->id)->first()->coin;
                            $response['message'] = __('Coin deducted successfully');
                        } else {
                            $response['status'] = false;
                            $response['message'] = __('Operation failed');
                        }
                    }
                } else {
                    $addedCoin = bcadd($userCoin->coin, $coin);
                    $addCoin = $userCoin->update(['coin' => $addedCoin]);
                    if ($addCoin) {
//                        $currentCoin = UserCoin::where('user_id', Auth::user()->id)->first()->coin;
                        $response['status'] = true;
                        $response['available_coin'] = UserCoin::where('user_id', Auth::user()->id)->first()->coin;
                        $response['message'] = __('Coin earned successfully');
                    } else {
                        $response['status'] = false;
                        $response['message'] = __('Operation failed');
                    }
                }

            } else {
                $response['status'] = false;
                $response['message'] = __('User Coin Account Not Found');
            }
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => __('Something went wrong . Please try again!')
            ];
            return $response;
        }

        return $response;
    }

}

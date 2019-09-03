<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserSaveRequest;
use App\Services\CommonService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
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
    /*
     * userList
     *
     * Active user list
     *
     *
     *
     *
     */

    public function userList()
    {
        $data['pageTitle'] = __('User List');
        $data['menu'] = 'userlist';
        $data['users'] = User::where('id','<>', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('admin.user.list', $data);
    }
    /*
     * userDetails
     *
     * User Details page
     *
     *
     *
     *
     */
    public function userDetails($id)
    {
        $data['pageTitle'] = __('User Details');
        $data['menu'] = 'userlist';
        $data['user'] = User::where('id', $id)->first();

        return view('admin.user.user-profile', $data);
    }

    /*
     * userMakeAdmin
     *
     * Make the user to admin
     *
     *
     *
     *
     */

    public function userMakeAdmin($id) {
        $affected_row = User::where('id', $id)
            ->update(['role' => USER_ROLE_ADMIN]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Made Admin successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }

    /*
     * userMakeUser
     *
     * Make the user to General User
     *
     *
     *
     *
     */

    public function userMakeUser($id) {
        $affected_row = User::where('id', $id)
            ->update(['role' => USER_ROLE_USER]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Made user successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }

    /*
     * addUser
     *
     * User add page
     *
     *
     *
     *
     */
    public function addUser()
    {
        $data['pageTitle'] = __('Add New User');
        $data['menu'] = 'userlist';

        return view('admin.user.add-edit', $data);
    }

    /**
     * userAddProcess
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function userAddProcess(UserSaveRequest $request)
    {
        if ($request->isMethod('post')) {

            $mail_key = $this->generate_email_verification_key();
            $mailTemplet = 'email.verify';

            $response = app(CommonService::class)->userRegistration($request, $mailTemplet, $mail_key);
            if (isset($response['success']) && $response['success']) {
                return redirect()->route('userList')->with('success', __('New user added successfully'));
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }
}

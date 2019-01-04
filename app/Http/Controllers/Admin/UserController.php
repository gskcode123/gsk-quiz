<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
}

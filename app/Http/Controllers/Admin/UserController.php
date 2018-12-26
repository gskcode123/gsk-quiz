<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $data['pageTitle'] = __('Admin|User List');
        return view('admin.', $data);
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
        $data['pageTitle'] = __('Admin|User Details');
        return view('admin.', $data);
    }
}

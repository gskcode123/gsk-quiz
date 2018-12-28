<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function adminDashboardView()
    {
        $data['pageTitle'] = __('Admin|Dashboard');
        return view('admin.dashboard', $data);
    }

    public function userDashboardView()
    {
        $data['pageTitle'] = __('User|Dashboard');
        return view('user.dashboard', $data);
    }

    public function leaderBoard()
    {
        $data['pageTitle'] = __('Leader Board');
        return view('admin.leaderboard', $data);
    }

}

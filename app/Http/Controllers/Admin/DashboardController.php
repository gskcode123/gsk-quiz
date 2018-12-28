<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Question;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function adminDashboardView()
    {
        $data['pageTitle'] = __('Admin|Dashboard');
        $data['totalQuestion'] = 0;
        $data['totalCategory'] = 0;
        $data['totalQuestion'] = Question::where('status', STATUS_ACTIVE)->count();
        $data['totalCategory'] = Category::where('status', STATUS_ACTIVE)->count();
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id', 'DESC')->limit(4)->get();
        $data['leaders'] = User::where(['active_status' => STATUS_ACTIVE, 'role' => 2])->orderBy('id', 'DESC')->limit(5)->get();

        return view('admin.dashboard', $data);
    }

    public function leaderBoard()
    {
        $data['pageTitle'] = __('Leader Board');
        return view('admin.leaderboard', $data);
    }

}

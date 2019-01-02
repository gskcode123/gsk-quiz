<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Question;
use App\Model\UserAnswer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /*
     * adminDashboardView
     *
     * Basic view of admin dashboard
     *
     *
     *
     *
     */
    public function adminDashboardView()
    {
        $data['pageTitle'] = __('Admin|Dashboard');
        $data['totalQuestion'] = 0;
        $data['totalCategory'] = 0;
        $data['totalQuestion'] = Question::where('status', STATUS_ACTIVE)->count();
        $data['totalCategory'] = Category::where('status', STATUS_ACTIVE)->count();
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id', 'DESC')->limit(4)->get();
        $data['leaders'] = UserAnswer::select(
            DB::raw('SUM(point) as score, user_id'))
            ->groupBy('user_id')
            ->orderBy('score', 'DESC')
            ->limit(5)
            ->get();

        return view('admin.dashboard', $data);
    }

    /*
     * leaderBoard
     *
     * Leader board who have attend the quiz
     * And show their score and ranking
     *
     *
     *
     */
    public function leaderBoard()
    {
        $data['pageTitle'] = __('Leader Board');
        $data['leaders'] = UserAnswer::select(
            DB::raw('SUM(point) as score, user_id'))
            ->groupBy('user_id')
            ->orderBy('score', 'DESC')
            ->get();

        return view('admin.leaderboard', $data);
    }

    /*
     * qsSearch
     *
     * Search the question in any page
     *
     *
     *
     *
     */

    public function qsSearch(Request $request)
    {
        $data['pageTitle'] = __('Rearch Result');
        $data['questions'] = Question::where('status',1)
            ->where('title','LIKE','%'.$request->item.'%')
            ->get();

        return view('admin.search-item', $data);
    }

}

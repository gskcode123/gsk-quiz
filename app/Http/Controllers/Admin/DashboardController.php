<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Question;
use App\Model\UserAnswer;
use App\User;
use Carbon\Carbon;
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
        $data['menu'] = 'dashboard';
        $data['totalQuestion'] = 0;
        $data['totalCategory'] = 0;
        $data['totalUser'] = 0;
        $data['totalQuestion'] = Question::where('status', STATUS_ACTIVE)->count();
        $data['totalCategory'] = Category::where('status', STATUS_ACTIVE)->count();
        $data['totalUser'] = User::where(['active_status'=> STATUS_ACTIVE, 'role'=> USER_ROLE_USER])->count();
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id', 'DESC')->limit(4)->get();
        $data['questions'] = Question::where('status', STATUS_ACTIVE)->orderBy('id', 'DESC')->limit(4)->get();
        $data['leaders'] = UserAnswer::select(
            DB::raw('SUM(point) as score, user_id'))
            ->groupBy('user_id')
            ->orderBy('score', 'DESC')
            ->limit(5)
            ->get();
        $monthlySales = UserAnswer::select(DB::raw('count(id) as totalUser'), DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('months')
            ->get();
        $allMonths = all_month();
        if (isset($monthlySales[0])) {
            foreach ($monthlySales as $sales) {
                $data['sale'][$sales->months] = $sales->totalUser;
            }
        }
        $allUsers= [];
        foreach ($allMonths as $month) {
            $allUsers[] =  isset($data['sale'][$month]) ? (int)$data['sale'][$month] : 0;
        }
        $data['monthly_user'] = $allUsers;

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
        $data['menu'] = 'leaderboard';
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
        $data['pageTitle'] = __('Search Result');
        $categories = Category::where('status',1)
            ->where('name','LIKE','%'.$request->item.'%')
            ->get();
        $questions = Question::where('status',1)
            ->where('title','LIKE','%'.$request->item.'%')
            ->get();
        $users = User::where('active_status',1)
            ->where('name','LIKE','%'.$request->item.'%')
            ->get();

        $data['users'] = $users;
        $data['questions'] = $questions;
        $data['categories'] = $categories;

        return view('admin.search-item', $data);
    }

}

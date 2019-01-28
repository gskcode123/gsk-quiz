<?php

namespace App\Http\Controllers\Api;

use App\Model\Category;
use App\Model\Question;
use App\Model\QuestionOption;
use App\Model\UserAnswer;
use App\Model\UserCoin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /*
     * questionCategory
     *
     * Question category list
     *
     *
     *
     *
     */
    public function questionCategory()
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong')];

        $categories = Category::where('status', STATUS_ACTIVE)->orderBy('serial', 'ASC')->get();
        $data['user_available_coin'] = 0;
        $data['user_available_point'] = calculate_score( Auth::user()->id);;
        if (isset(Auth::user()->userCoin->coin)) {
            $data['user_available_coin'] = Auth::user()->userCoin->coin;
        }
        $item = [];
        if (isset($categories)) {
            foreach ($categories as $list) {
                $item[] = [
                    'id' => $list->id,
                    'category_id' => encrypt($list->id),
                    'name' => $list->name,
                    'description' => $list->description,
                    'image' => asset(path_category_image() . $list->image),
                    'qs_limit' => $list->qs_limit,
                    'time_limit' => $list->time_limit,
                    'max_limit' => $list->max_limit,
                    'serial' => $list->serial,
                    'status' => $list->status,
                    'coin' => $list->coin,
                    'question_amount' => count_question($list->id),
                    'is_locked' => check_category_unlock($list->id,$list->coin)
                ];
            }

            if (!empty($item)) {
                $data['message'] = __('Category List');
                $data['success'] = true;
                $data['category_list'] = $item;
            }
        } else {
            $data ['success'] =  false;
            $data['message'] = __('No data found');
        }
        return response()->json($data);
    }

    /*
     * singleCategory
     *
     * Show the Question list under this category
     *
     *
     *
     *
     */

    public function singleCategoryQuestion($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => __('Invalid Category id')
            ];

            return response()->json($data);
        }
        $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong')];
        $data['user_available_coin'] = 0;
        $data['user_available_point'] = calculate_score( Auth::user()->id);;
        if (isset(Auth::user()->userCoin->coin)) {
            $data['user_available_coin'] = Auth::user()->userCoin->coin;
        }
        $category = Category::where('id',$id)->first();
        $limit = $category->qs_limit;
        $timeLimit = $category->time_limit;
        $availableQuestions = '';

        $availableQuestions = Question::with('question_option')
            ->where(['questions.category_id' => $id,'questions.status'=> STATUS_ACTIVE])
            ->whereNotIn('questions.id', UserAnswer::select('question_id')->where(['user_id' => Auth::id()]))
            ->select('questions.*')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
        $data['hints_coin'] = 0;
        if (!empty(allsetting('hints_coin'))) {
            $data['hints_coin'] = allsetting('hints_coin');
        }
        $lists = [];

        if (isset($availableQuestions)) {
            $totalQuestion = 0;
            $totalCoin = 0;
            $totalPoint = 0;
            foreach ($availableQuestions as $question) {
                $item = [];
                $itemImage = [];
                if ($question->type == 1) {
                    foreach ($question->question_option as $option) {
                        $item[] = [
                            'id' => $option->id,
                            'question_option' => $option->option_title
                        ];
                    }
                } else {
                    $itemImage [] = [
                        'id' => isset($question->question_option[0]) ? $question->question_option[0]->id : '',
                        'question_option' => isset($question->question_option[0]) ?  asset(path_question_option1_image() . $question->question_option[0]->option_image) : ''
                    ];
                    $itemImage [] = [
                        'id' => isset($question->question_option[1]) ? $question->question_option[1]->id : '',
                        'question_option' => isset($question->question_option[1]) ?  asset(path_question_option2_image() . $question->question_option[1]->option_image) : ''
                    ];
                    $itemImage [] = [
                        'id' => isset($question->question_option[2]) ? $question->question_option[2]->id : '',
                        'question_option' => isset($question->question_option[2]) ? asset(path_question_option3_image() . $question->question_option[2]->option_image) : ''
                    ];
                    $itemImage [] = [
                        'id' => isset($question->question_option[3]) ? $question->question_option[3]->id : '',
                        'question_option' => isset($question->question_option[3]) ? asset(path_question_option4_image() . $question->question_option[3]->option_image) : ''
                    ];
                }

                $lists[] = [
                    'category' => $question->qsCategory->name,
                    'category_id' => $question->qsCategory->id,
                    'id' => $question->id,
                    'question_id' => encrypt($question->id),
                    'title' => $question->title,
                    'type' => $question->type,
                    'image' => asset(path_question_image() . $question->image),
                    'point' => $question->point,
                    'coin' => $question->coin,
                    'time_limit' => isset($question->time_limit) ? $question->time_limit : $timeLimit,
                    'status' => $question->status,
                    'hints' => $question->hints,
                    'skip_coin' => $question->skip_coin,
                    'options' => $question->type == 1 ? $item : $itemImage,
//                    'options2' => $itemImage,
//                    'options' => $question->question_option->toArray()
                ];

                $totalQuestion ++;
                $totalPoint = $totalPoint + $question->point;
                $totalCoin = $totalCoin + $question->coin;
            }


            if (!empty($lists)) {
                $data['success'] = true;
                $data['totalQuestion'] = $totalQuestion;
                $data['totalPoint'] = $totalPoint;
                $data['totalCoin'] = $totalCoin;
                $data['availableQuestionList'] = $lists;
                $data['message'] = __('Available Question List');
            } else {
                $data = [
                    'success' => false,
                    'message' => __('No question found under this category')
                ];
            }
        } else {
            $data = [
                'success' => false,
                'message' => __('No question found under this category')
            ];
        }

        return response()->json($data);
    }

    /*
     * singleCategory
     *
     * Show the Question list under this category
     *
     *
     *
     *
     */

//    public function singleQuestion($id)
//    {
//        try {
//            $id = decrypt($id);
//        } catch (\Exception $e) {
//            $data = [
//                'success' => false,
//                'message' => __('Invalid Category id')
//            ];
//
//            return response()->json($data);
//        }
//        $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong')];
//
////        $question = Question::join('user_answers', 'user_answers.question_id', '=', 'questions.id')
////            ->where(['questions.id' => $id, 'questions.status'=> STATUS_ACTIVE])
////            ->whereNotIn('user_answers.question_id',[$id])
////            ->whereNotIn('user_answers.user_id',[Auth::user()->id])
////            ->first();
//        $question = Question::where(['questions.id' => $id, 'questions.status'=> STATUS_ACTIVE])->first();
////        dd($id,$question);
//        $answers = QuestionOption::where('question_id', $id)->get();
//
//        if (isset($question) && isset($answers)) {
//            $list = [
//                'category' => $question->qsCategory->name,
//                'category_id' => $question->qsCategory->id,
//                'id' => $question->id,
//                'question_id' => encrypt($question->id),
//                'title' => $question->title,
//                'type' => $question->type,
//                'image' => asset(path_question_image() . $question->image),
//                'point' => $question->point,
//                'coin' => $question->coin,
//                'status' => $question->status,
//            ];
//
//            $timeLimit = Category::where('id', $question->category_id)->first()->time_limit;
//            $list['time_limit'] = isset($question->time_limit) ? $question->time_limit : $timeLimit;
//            foreach ($answers as $option) {
//                $item[] = [
//                    'id' => $option->id,
//                    'option_title' => $option->option_title
//                ];
//            }
//            $insert = UserAnswer::create([
//                'user_id' => Auth::user()->id,
//                'category_id' => $question->qsCategory->id,
//                'question_id' => $question->id,
//                'type' => $question->type,
//                'status' => 0
//            ]);
//            $data = [
//                'success' => true,
//                'question' => $list,
//                'options' => $item
//            ];
//        } else {
//            $data = [
//                'success' => false,
//                'message' => __('No data found')
//            ];
//        }
//
//        return response()->json($data);
//    }

    /*
     * submitAnswer
     *
     * Submit the answer
     *
     *
     *
     *
     */
    public function submitAnswer(Request $request, $id)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something Went wrong !')];
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => __('Invalid Question id')
            ];

            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'answer' => 'required',
//            'time_limit' => 'required',
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
        try {
            $rightAnswer = [];
            $userCoins = UserCoin::where('user_id', Auth::user()->id)->first();
            $correctAnswer = QuestionOption::where(['question_id'=> $id, 'is_answer' => ANSWER_TRUE])->first();
            if(isset($correctAnswer)) {
                $rightAnswer = [
                    'option_id' => $correctAnswer->id,
//                    'option_title' => $correctAnswer->option_title,
                ];
            }
            $question = Question::where(['id' => $id])->first();
            $option = QuestionOption::where(['id'=> $request->answer, 'question_id'=> $id])->first();
            $userAnswer = UserAnswer::where(['question_id' => $id, 'user_id' => Auth::user()->id])->first();

            $input =[
                'user_id' => Auth::user()->id,
                'category_id' => $question->qsCategory->id,
                'question_id' => $question->id,
                'type' => $question->type,
            ];
            if ($option) {

//                $viewTime = Carbon::parse($userAnswer->created_at);
//                $checkTime = Carbon::parse(Carbon::now());
//                $diffTime = $checkTime->diffInSeconds($viewTime);
//                //dd($sendTime,$checkTime, $diffTime);
//                if ($diffTime <= (60 * $request->time_limit)) {
                        if ($option->is_answer == ANSWER_TRUE) {
                            $input['is_correct'] = ANSWER_TRUE;
                            $input['point'] = $question->point;
                            $input['coin'] = $question->coin;
                            if (empty($userAnswer)) {
                                $updatePoint = $userCoins->increment('coin', $question->coin);
                            }
                            $data = [
                                'success' => true,
                                'message' => __('Right Answer'),
                            ];
                        } else {
                            $data = [
                                'success' => false,
                                'message' => __('Wrong Answer'),
                                'right_answer' => $rightAnswer
                            ];
                        }
//                } else {
//                    $data = [
//                        'success' => false,
//                        'message' => __('Sorry Time out!')
//                    ];
//                }
            } else {
                $data = [
                    'success' => false,
                    'message' => __('Wrong Answer'),
                    'right_answer' => $rightAnswer
                ];
            }
            if ($userAnswer) {
                $userAnswer->update($input);
            } else {
                $insert = UserAnswer::create($input);
            }

            $data['total_point'] = calculate_score( Auth::user()->id);
            $data['total_coin'] = User::where('id',Auth::user()->id)->first()->userCoin->coin;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
//                'message' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again!',
            ]);
        }

        return response()->json($data);
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
    public function leaderBoard($type=null)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something Went wrong !')];
        if ($type == 2) {
            $leaders = UserAnswer::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->whereDate('created_at', Carbon::today())
                ->orderBy('score', 'DESC')
                ->get();
        } elseif($type == 3) {
            $leaders = UserAnswer::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('score', 'DESC')
                ->get();
        } else {
            $leaders = UserAnswer::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->orderBy('score', 'DESC')
                ->get();
        }

        $lists = [];
        if (isset($leaders)) {
            $rank = 1;
            foreach ($leaders as $item) {

                $lists[] = [
                    'user_id' => $item->user_id,
                    'photo' => asset(pathUserImage() . $item->user->photo),
                    'name' => $item->user->name,
                    'score' => $item->score,
                    'coin' => isset($item->user->userCoin->coin) ? $item->user->userCoin->coin : 0,
                    'ranking' => $rank++,
                ];
            }
            if (!empty($lists)) {
                $data = [
                    'success' => true,
                    'leaderList' => $lists,
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => __('No data found')
                ];
            }
        } else {
            $data = [
                'success' => false,
                'message' => __('No data found')
            ];
        }

        return response()->json($data);
    }

}

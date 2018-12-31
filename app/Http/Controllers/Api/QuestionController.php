<?php

namespace App\Http\Controllers\Api;

use App\Model\Category;
use App\Model\Question;
use App\Model\QuestionOption;
use App\Model\UserAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
                    'question_amount' => count_question($list->id),
                ];
            }

            if (!empty($item)) {
                $data = [
                    'success' => true,
                    'category_list' => $item
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

    /*
     * singleCategory
     *
     * Show the Question list under this category
     *
     *
     *
     *
     */

    public function singleCategory($id)
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

        $limit = Category::where('id',$id)->first()->qs_limit;
        $questions = Question::where(['category_id' => $id, 'status' => STATUS_ACTIVE])
            ->limit($limit)
            ->orderBy('id','ASC')
            ->get();
        if (isset($questions)) {
            foreach ($questions as $item) {
                $list[] = [
                    'category' => $item->qsCategory->name,
                    'id' => $item->id,
                    'question_id' => encrypt($item->id),
                    'title' => $item->title,
                    'type' => $item->type,
                    'image' => asset(path_question_image() . $item->image),
                    'time_limit' => $item->time_limit,
                    'point' => $item->point,
                    'coin' => $item->coin,
                    'status' => $item->status,
                ];
            }

            if (!empty($list)) {
                $data = [
                    'success' => true,
                    'question_list' => $list
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

    /*
     * singleCategory
     *
     * Show the Question list under this category
     *
     *
     *
     *
     */

    public function singleQuestion($id)
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

//        $question = Question::join('user_answers', 'user_answers.question_id', '=', 'questions.id')
//            ->where(['questions.id' => $id, 'questions.status'=> STATUS_ACTIVE])
//            ->whereNotIn('user_answers.question_id',[$id])
//            ->whereNotIn('user_answers.user_id',[Auth::user()->id])
//            ->first();
        $question = Question::where(['questions.id' => $id, 'questions.status'=> STATUS_ACTIVE])->first();
//        dd($id,$question);
        $answers = QuestionOption::where('question_id', $id)->get();

        if (isset($question) && isset($answers)) {
            $list = [
                'category' => $question->qsCategory->name,
                'category_id' => $question->qsCategory->id,
                'id' => $question->id,
                'question_id' => encrypt($question->id),
                'title' => $question->title,
                'type' => $question->type,
                'image' => asset(path_question_image() . $question->image),
                'point' => $question->point,
                'coin' => $question->coin,
                'status' => $question->status,
            ];

            $timeLimit = Category::where('id', $question->category_id)->first()->time_limit;
            $list['time_limit'] = isset($question->time_limit) ? $question->time_limit : $timeLimit;
            foreach ($answers as $option) {
                $item[] = [
                    'id' => $option->id,
                    'option_title' => $option->option_title
                ];
            }
            $insert = UserAnswer::create([
                'user_id' => Auth::user()->id,
                'category_id' => $question->qsCategory->id,
                'question_id' => $question->id,
                'type' => $question->type,
                'status' => 0
            ]);
            $data = [
                'success' => true,
                'question' => $list,
                'options' => $item
            ];
        } else {
            $data = [
                'success' => false,
                'message' => __('No data found')
            ];
        }

        return response()->json($data);
    }

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
            'time_limit' => 'required',
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
            $question = Question::where(['id' => $id])->first();
            $userAnswer = UserAnswer::where(['question_id' => $id, 'user_id' => Auth::user()->id])->first();
            $option = QuestionOption::where(['id'=> $request->answer, 'question_id'=> $id])->first();
//            dd($question);
            if ($option) {
                $viewTime = Carbon::parse($userAnswer->created_at);
                $checkTime = Carbon::parse(Carbon::now());
                $diffTime = $checkTime->diffInSeconds($viewTime);
                //dd($sendTime,$checkTime, $diffTime);
                if ($diffTime <= (60 * $request->time_limit)) {
                    if ($question->type == MULTIPLE_ANSWER) {
                        if ($option->is_answer == ANSWER_TRUE) {
                            $userAnswer->is_correct = ANSWER_TRUE;
                            $userAnswer->point = $question->point;
                            $userAnswer->status = 1;
                            $userAnswer->update();
                            $data = [
                                'success' => true,
                                'message' => __('Right Answer'),
                            ];
                        } else {
                            $data = [
                                'success' => false,
                                'message' => __('Wrong Answer'),
                            ];
                        }
                    }
                } else {
                    $data = [
                        'success' => false,
                        'message' => __('Sorry Time out!')
                    ];
                }
            } else {
                $data = [
                    'success' => false,
                    'message' => __('Wrong Answer')
                ];
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                //'message' => 'Something went wrong. Please try again!',
            ]);
        }

        return response()->json($data);
    }
}

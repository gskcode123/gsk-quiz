<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Question;
use App\Model\QuestionOption;
use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    /*
     * questionList
     *
     * List of question
     *
     *
     *
     *
     */
    public function questionList()
    {
        $data['pageTitle'] = __('Question List');
        $data['menu'] = 'question';
        $data['items'] = Question::orderBy('id', 'DESC')->get();

        return view('admin.question.list', $data);
    }
    /*
     * categoryQuestionList
     *
     * List of categorise question
     *
     *
     *
     *
     */
    public function categoryQuestionList($cat_id)
    {
        $data['pageTitle'] = __('Category Question List');
        $data['catName'] = Category::where('id', $cat_id)->first()->name;
        $data['menu'] = 'category';
        $data['items'] = Question::orderBy('id', 'DESC')->where('category_id', $cat_id)->get();

        return view('admin.question.cat-qs-list', $data);
    }

    /*
     * questionCreate
     *
     * Question create page
     *
     *
     *
     *
     */

    public function questionCreate()
    {
        $data['pageTitle'] = __('Add Question');
        $data['menu'] = 'question';
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id','ASC')->get();

        return view('admin.question.add', $data);
    }

    /*
     * questionSave
     *
     * Question saving process
     *
     *
     *
     *
     */

    public function questionSave(Request $request)
    {
//        dd($request->all());
        $rules = [
            'title' => ['required', Rule::unique('questions')->ignore($request->edit_id, 'id')],
            'category_id' => 'required',
            'skip_coin' => 'required|numeric|between:0,100',
            'hints' => 'required',
            'type' => 'required',
            'status' => 'required',
//            'options' => 'required',
            'point' => 'required|numeric|between:0,100',
        ];

        $messages = [
            'title.required' => __('Question Title field can not be empty'),
            'point.required' => __('Question point field can not be empty'),
            'status.required' => __('Status field can not be empty'),
            'options.required' => __('Option field can not be empty'),
            'category_id.required' => __('Must be select a category'),
            'type.required' => __('Must be select a question type'),
            'skip_coin.required' => __('Skip coin field is required'),
            'hints.required' => __('Hints field is required'),
        ];
        if ($request->type == 1) {
//            $rules['options'] = 'required';
        }
        if (!empty($request->coin)) {
            $rules['coin'] = 'numeric|between:1,1000';
        }
        if (!empty($request->time_limit)) {
            $rules['time_limit'] = 'numeric|between:1,10';
        }
        if (!empty($request->image)) {
            $rules['image'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:4000';
        }
        if (!empty($request->option_image1)) {
            $rules['option_image1'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:4000';
        }
        if (!empty($request->option_image2)) {
            $rules['option_image2'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:4000';
        }
        if (!empty($request->option_image3)) {
            $rules['option_image3'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:4000';
        }
        if (!empty($request->option_image4)) {
            $rules['option_image4'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:4000';
        }
        if (empty($request->edit_id) && ($request->type == 2)) {
            $rules['option_image1'] = 'required';
            $rules['option_image2'] = 'required';
            $rules['option_image3'] = 'required';
            $rules['option_image4'] = 'required';
        }

        $this->validate($request, $rules,$messages);
        try {
            $data = [
                'title' => $request->title,
                'category_id' => $request->category_id,
                'type' => $request->type,
                'time_limit' => $request->time_limit,
                'answer' => $request->answer,
                'point' => $request->point,
                'serial' => $request->serial,
                'status' => $request->status,
                'skip_coin' => $request->skip_coin,
                'hints' => $request->hints,
            ];

            if (!empty($request->coin)) {
                $data['coin'] = $request->coin;
            } else {
                $data['coin'] = 0;
            }
            if (!empty($request->edit_id)) {
                $qs = Question::where('id', $request->edit_id)->first();
            }
            if (!empty($request['image'])) {
                $old_img = '';
                if (!empty($qs->image)) {
                    $old_img = $qs->image;
                }
                $data['image'] = fileUpload($request['image'], path_question_image(), $old_img);
            }
            if (!empty($request->edit_id)) {
                $update = Question::where(['id' => $request->edit_id])->update($data);
                if ($update) {
                    if ($request->type == 2) {
                        app(CommonService::class)->saveOptionImage($request, $request->edit_id);
                    } else {
                        $questionOption = QuestionOption::where('question_id', $request->edit_id)->delete();
                        if ($questionOption) {
                            $options = $request->options;
                            $types = $request->ans_type;
                            $size = sizeof($options);
                            for ($i = 0; $i < $size; $i++) {
                                $insertOption = QuestionOption::create([
                                    'question_id' => $request->edit_id,
                                    'option_title' => $options[$i],
                                    'is_answer' => $types[$i]
                                ]);
                            }
                        }
                    }

                    return redirect()->back()->with('success', __('Question Updated Successfully'));
                } else {
                    return redirect()->back()->with('dismiss', __('Update Failed'));
                }
            } else {
                $categoryLimit = Category::where('id', $request->category_id)->first()->max_limit;
                $addedQuestion = Question::where('category_id', $request->category_id)->count();
                if ($categoryLimit <= $addedQuestion) {
                    return redirect()->route('questionList')->with('dismiss', __('Questions limit exceeded'));
                }
                $insert = Question::create($data);
                if ($insert) {
                    if ($request->type == 2) {
                        app(CommonService::class)->saveOptionImage($request,$insert->id);
                    } else {
                        $options = $request->options;
                        $types = $request->ans_type;
                        $size = sizeof($options);
                        for ($i = 0; $i < $size; $i++) {
                            $insertOption = QuestionOption::create([
                                'question_id' => $insert->id,
                                'option_title' => $options[$i],
                                'is_answer' => $types[$i]
                            ]);
                        }
                    }

                    return redirect()->route('questionList')->with('success', __('Question Created Successfully'));
                } else {
                    return redirect()->route('questionList')->with('dismiss', __('Save Failed'));
                }
            }

        } catch (\Exception $e) {
//            dd($e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    /*
     * questionEdit
     *
     * Edit the question
     *
     *
     *
     *
     */

    public function questionEdit($id)
    {
        $data['pageTitle'] = __('Edit Question');
        $data['menu'] = 'question';
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id','ASC')->get();

        if (!empty($id) && is_numeric($id)) {
            $data['question'] = Question::findOrFail($id);
            $data['qsOptions'] = QuestionOption::where('question_id', $id)->get();
        }
        return view('admin.question.add', $data);
    }

    /*
     * questionDelete
     *
     * Delete the question
     *
     *
     *
     *
     */

    public function questionDelete($id)
    {
        $item = Question::where('id', $id)->first();
        $destroy = $item->delete();
        if ($destroy) {
            QuestionOption::where('question_id', $id)->delete();
            return redirect()->back()->with('success', __('Question Deleted successfully'));
        } else {
            return redirect()->back()->with('dismiss', __('Something went wrong!'));
        }
    }

    /*
     * questionActivate
     *
     * Activate the question
     *
     *
     *
     *
     */

    public function questionActivate($id) {
        $affected_row = Question::where('id', $id)
            ->update(['status' => STATUS_ACTIVE]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Activated successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }

    /*
     * questionDectivate
     *
     * Deactivate the question
     *
     *
     *
     *
     */

    public function questionDectivate($id) {
        $affected_row = Question::where('id', $id)
            ->update(['status' => STATUS_INACTIVE]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Deactivated successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }
}

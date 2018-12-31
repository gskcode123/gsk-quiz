<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Question;
use App\Model\QuestionOption;
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
        $data['items'] = Question::orderBy('id', 'DESC')->get();

        return view('admin.question.list', $data);
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
//        dd($request->all(),$request->options, $request->ans_type);

        $rules = [
            'title' => ['required', Rule::unique('questions')->ignore($request->edit_id, 'id')],
            'category_id' => 'required',
            'type' => 'required',
            'status' => 'required',
            'options' => 'required',
            'point' => 'required|numeric|between:0,100',
        ];

        $messages = [
            'title.required' => __('Question Title field can not be empty'),
            'point.required' => __('Question point field can not be empty'),
            'status.required' => __('Status field can not be empty'),
            'options.required' => __('Option field can not be empty'),
            'category_id.required' => __('Must be select a category'),
            'type.required' => __('Must be select a question type'),
        ];

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
            ];
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

                    return redirect()->back()->with('success', __('Question Updated Successfully'));
                } else {
                    return redirect()->back()->with('dismiss', __('Update Failed'));
                }
            } else {
                $insert = Question::create($data);
                if ($insert) {
                    $options = $request->options;
                    $types = $request->ans_type;
                    $size = sizeof($options);
                    for ($i = 0; $i < $size; $i++) {
                        $insertOption = QuestionOption::update([
                            'question_id' => $insert->id,
                            'option_title' => $options[$i],
                            'is_answer' => $types[$i]
                        ]);

                    }
                    return redirect()->back()->with('success', __('Question Created Successfully'));
                } else {
                    return redirect()->back()->with('dismiss', __('Save Failed'));
                }
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }    }

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
        }    }
}

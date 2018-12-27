<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Question;
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

        return view('admin.', $data);
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
        return view('admin.', $data);
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
        $rules = [
            'name' => ['required', Rule::unique('categories')->ignore($this->id, 'id')],
            'qs_limit' => 'required|numeric|min:1',
            'time_limit' => 'required|numeric|between:0,10',
        ];

        $messages = [
            'name.required' => __('Name field can not be empty'),
            'name.unique' => __('This Name already taken'),
            'qs_limit.required' => __('Quiz Limit field can not be empty'),
            'password_confirmation.required' => __('Password confirmed field can not be empty'),
            'password.min' => __('Password length must be above 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!'),
            'email.required' => __('Email field can not be empty'),
            'email.unique' => __('Email Address already exists'),
            'email.email' => __('Invalid email address'),
        ];

        $this->validate($request, $rules,$messages);
        return view('admin.');
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
        return view('admin.', $data);
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
        return view('admin.');
    }
}

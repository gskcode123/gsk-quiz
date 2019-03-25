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

    public function questionCreate(Request $request)
    {
        $data['pageTitle'] = __('Add Question');
        $data['menu'] = 'question';
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id','ASC')->whereNull('parent_id')->get();

        if ($request->ajax()) {
            $data_genetare = '<option value="">' . __('Select Sub Category') . '</option>';
            if (!empty($request->val)) {
                $sub_cat = Category::orderBy('id', 'DESC')->where(['status' => STATUS_ACTIVE,'parent_id'=>$request->val])->get();
                if (isset($sub_cat[0])) {
                    foreach ($sub_cat as $sc) {
                        $data_genetare .= '<option value="' . $sc->id . '">' . $sc->name . '</option>';
                    }
                }
            }
            return response()->json($data_genetare);
        }
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
        $rules = [
//            'title' => ['required', Rule::unique('questions')->ignore($request->edit_id, 'id')],
            'category_id' => 'required',
            'skip_coin' => 'required|numeric|between:0,100',
//            'hints' => 'required',
            'type' => 'required',
            'status' => 'required',
            'point' => 'required|numeric|between:0,100',

        ];

        $messages = [
//            'title.required' => __('Question Title field can not be empty'),
            'point.required' => __('Question point field can not be empty'),
            'status.required' => __('Status field can not be empty'),
            'options.required' => __('Option field can not be empty'),
            'category_id.required' => __('Must be select a category'),
            'type.required' => __('Must be select a question type'),
            'skip_coin.required' => __('Skip coin field is required'),
            'hints.required' => __('Hints field is required'),
        ];

        if (!empty($request->coin)) {
            $rules['coin'] = 'numeric|between:1,1000';
        }
        if (!empty($request->time_limit)) {
            $rules['time_limit'] = 'numeric|between:1,10';
        }
        if (!empty($request->image)) {
            $rules['image'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($request->option_image1)) {
            $rules['option_image1'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($request->option_image2)) {
            $rules['option_image2'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($request->option_image3)) {
            $rules['option_image3'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($request->option_image4)) {
            $rules['option_image4'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($request->option_image5)) {
            $rules['option_image5'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }

        $this->validate($request, $rules,$messages);

        if (empty($request->edit_id)) {
            if(empty($request->title) && empty($request->image)) {
                return redirect()->back()->withInput()->with('dismiss', __('Must be input title or upload image'));
            }
            $text = $this->preg_grep_keys_values('~option_text~i', $request->all());
            $image = $this->preg_grep_keys_values('~option_image~i', $request->all());
            $textCount = count(array_filter($text));
            $imgCount = count(array_filter($image));

            if($textCount + $imgCount < 2) {
                return redirect()->back()->withInput()->with('dismiss', __('Atleast two options are required'));
            }
        }

        if ((!empty($request->option_text1) && !empty($request->option_image1)) || (!empty($request->option_text2) && !empty($request->option_image2)) ||
            (!empty($request->option_text3) && !empty($request->option_image3)) || (!empty($request->option_text4) && !empty($request->option_image4)) ||
            (!empty($request->option_text5) && !empty($request->option_image5))) {

            return redirect()->back()->withInput()->with('dismiss', __('At a time only text or only image sholud be a option'));
        }
        if (!in_array(1,[$request->ans_type1,$request->ans_type2,$request->ans_type3,$request->ans_type4, $request->ans_type5])) {
            return redirect()->back()->withInput()->with('dismiss', __('Atleast one answer must be rigth. '));
        }
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
                'sub_category_id' => $request->sub_category_id,
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
                    app(CommonService::class)->saveOptions($request, $request->edit_id);

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
                    app(CommonService::class)->saveOptions($request,$insert->id);

                    return redirect()->route('questionList')->with('success', __('Question Created Successfully'));
                } else {
                    return redirect()->route('questionList')->with('dismiss', __('Save Failed'));
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    public function preg_grep_keys_values($pattern, $input, $flags = 0) {
        return array_merge(
            array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags))),
            preg_grep($pattern, $input, $flags)
        );
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
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id','ASC')->whereNull('parent_id')->get();

        if (!empty($id) && is_numeric($id)) {
            $data['question'] = Question::findOrFail($id);
            $data['sub_categories'] = Category::orderBy('id', 'DESC')->where(['status' => STATUS_ACTIVE,'parent_id'=>$data['question']->category_id])->get();
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

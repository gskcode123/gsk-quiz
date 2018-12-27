<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /*
     * qsCategoryList
     *
     * List of question category
     *
     *
     *
     *
     */
    public function qsCategoryList()
    {
        $data['pageTitle'] = __('Category List');
        $data['categories'] = Category::orderBy('id', 'DESC')->get();

        return view('admin.', $data);
    }

    /*
     * qsCategoryCreate
     *
     * Question category create page
     *
     *
     *
     *
     */

    public function qsCategoryCreate()
    {
        $data['pageTitle'] = __('Add Category');
        return view('admin.', $data);
    }

    /*
     * qsCategorySave
     *
     * Question category saving process
     *
     *
     *
     *
     */

    public function qsCategorySave(Request $request)
    {
        $rules = [
            'name' => ['required', Rule::unique('categories')->ignore($this->id, 'id')],
            'serial' => ['required', Rule::unique('categories')->ignore($this->id, 'id')],
            'qs_limit' => 'required|numeric|min:1',
            'max_limit' => 'required|numeric|min:1',
            'time_limit' => 'required|numeric|between:0,10',
        ];

        $messages = [
            'name.required' => __('Name field can not be empty'),
            'name.unique' => __('This Name already taken'),
            'serial.unique' => __('This Serial already taken'),
            'qs_limit.required' => __('Quiz Limit field can not be empty'),
            'max_limit.required' => __('Max Limit field can not be empty'),
            'time_limit.required' => __('Max Limit field can not be empty'),
            'serial.required' => __('Serial field can not be empty'),
        ];

        if (!empty($request->image)) {
            $rules['image'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:20000';
        }
        $this->validate($request, $rules, $messages);
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'qs_limit' => $request->qs_limit,
                'time_limit' => $request->time_limit,
                'max_limit' => $request->max_limit,
                'serial' => $request->serial,
                'status' => $request->status,
            ];
            if (!empty($request->edit_id)) {
                $cat = Category::where('id', $request->edit_id)->first();
            }
            if (!empty($request['image'])) {
                $old_img = '';
                if (!empty($cat->image)) {
                    $old_img = $cat->image;
                }
                $data['image'] = fileUpload($request['image'], path_category_image(), $old_img);
            }
            if (!empty($request->edit_id)) {
                $update = Category::where(['id' => $request->edit_id])->update($data);
                if ($update) {
                    return redirect()->back()->with('success', __('Category Updated Successfully'));
                } else {
                    return redirect()->back()->with('dissmiss', __('Update Failed'));
                }
            } else {
                $insert = Category::create($data);
                if ($insert) {
                    return redirect()->back()->with('success', __('Category Created Successfully'));
                } else {
                    return redirect()->back()->with('dissmiss', __('Save Failed'));
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('dissmiss', __('Something went wrong'));
        }

    }

    /*
     * qsCategoryEdit
     *
     * Edit the question category
     *
     *
     *
     *
     */

    public function qsCategoryEdit($id)
    {
        $data['pageTitle'] = __('Edit Category');
        if (!empty($id) && is_numeric($id)) {
            $data['category'] = Category::findOrFail($id);
        }
        return view('admin.', $data);
    }

    /*
     * qsCategoryDelete
     *
     * Delete the question category
     *
     *
     *
     *
     */

    public function qsCategoryDelete($id)
    {
        if(isset($id) && is_numeric($id)){
            $item = Category::where('id', $id)->first();
            $destroy = $item->delete();
            if ($destroy) {
                return redirect()->back()->with('success', __('Category Deleted successfully'));
            } else {
                return redirect()->back()->with('dismiss', __('Something went wrong!'));
            }
        } else {
            return redirect()->back()->with(['success'=>__('Category not found')]);
        }
    }
}

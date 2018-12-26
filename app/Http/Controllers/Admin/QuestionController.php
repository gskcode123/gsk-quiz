<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /*
     * userList
     *
     * Active user list
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

    public function qsCategoryCreate()
    {
        $data['pageTitle'] = __('Add Category');
        return view('admin.', $data);
    }

    public function qsCategorySave(Request $request)
    {
        return view('admin.');
    }

    public function qsCategoryEdit($id)
    {
        $data['pageTitle'] = __('Edit Category');
        return view('admin.', $data);
    }

    public function qsCategoryDelete($id)
    {
        return view('admin.');
    }
}

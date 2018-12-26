<?php

Route::group(['middleware' => ['auth','admin'], 'prefix' => 'admin'], function() {
    Route::get('/dashboard', 'Admin\DashboardController@adminDashboardView')->name('adminDashboardView');

    // Setting
    Route::get('general-setting', 'Admin\SettingController@generalSetting')->name('generalSetting');
    Route::post('save-setting', 'Admin\SettingController@saveSettings')->name('saveSettings');
    //User Management
    Route::get('user-list', 'Admin\UserController@userList')->name('userList');
    Route::get('user-details/{id}', 'Admin\UserController@userDetails')->name('userDetails');

    //Question Category
    Route::get('question-category-list', 'Admin\QuestionController@qsCategoryList')->name('qsCategoryList');
    Route::get('question-category-create', 'Admin\QuestionController@qsCategoryCreate')->name('qsCategoryCreate');
    Route::post('question-category-save', 'Admin\QuestionController@qsCategorySave')->name('qsCategorySave');
    Route::get('question-category-edit/{id}', 'Admin\QuestionController@qsCategoryEdit')->name('qsCategoryEdit');
    Route::get('question-category-delete/{id}', 'Admin\QuestionController@qsCategoryDelete')->name('qsCategoryDelete');

    //Question
    Route::get('question-list', 'Admin\QuestionController@questionList')->name('questionList');
    Route::get('question-create', 'Admin\QuestionController@questionCreate')->name('questionCreate');
    Route::post('question-save', 'Admin\QuestionController@questionSave')->name('questionSave');
    Route::get('question-edit/{id}', 'Admin\QuestionController@questionEdit')->name('qsCategoryEdit');
    Route::get('question-delete/{id}', 'Admin\QuestionController@questionDelete')->name('questionDelete');

});
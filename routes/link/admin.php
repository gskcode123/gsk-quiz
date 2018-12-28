<?php

Route::group(['middleware' => ['auth','admin']], function() {
    Route::get('/', 'Admin\DashboardController@adminDashboardView')->name('adminDashboardView');

    //profile setting
    Route::get('/profile','Admin\ProfileController@userProfile')->name('userProfile');
    Route::get('/password-change','Admin\ProfileController@passwordChange')->name('passwordChange');
    Route::post('/update-profile','Admin\ProfileController@updateProfile')->name('updateProfile');
    Route::post('/change-password','Admin\ProfileController@changePassword')->name('changePassword');

    //leaderboard
    Route::get('/leader-board', 'Admin\DashboardController@leaderBoard')->name('leaderBoard');

    // Setting
    Route::get('general-setting', 'Admin\SettingController@generalSetting')->name('generalSetting');
    Route::post('save-setting', 'Admin\SettingController@saveSettings')->name('saveSettings');

    //User Management
    Route::get('user-list', 'Admin\UserController@userList')->name('userList');
    Route::get('user-details/{id}', 'Admin\UserController@userDetails')->name('userDetails');

    //Question Category
    Route::get('question-category-list', 'Admin\CategoryController@qsCategoryList')->name('qsCategoryList');
    Route::get('question-category-create', 'Admin\CategoryController@qsCategoryCreate')->name('qsCategoryCreate');
    Route::post('question-category-save', 'Admin\CategoryController@qsCategorySave')->name('qsCategorySave');
    Route::get('question-category-edit/{id}', 'Admin\CategoryController@qsCategoryEdit')->name('qsCategoryEdit');
    Route::get('question-category-delete/{id}', 'Admin\CategoryController@qsCategoryDelete')->name('qsCategoryDelete');

    //Question
    Route::get('question-list', 'Admin\QuestionController@questionList')->name('questionList');
    Route::get('question-create', 'Admin\QuestionController@questionCreate')->name('questionCreate');
    Route::post('question-save', 'Admin\QuestionController@questionSave')->name('questionSave');
    Route::get('question-edit/{id}', 'Admin\QuestionController@questionEdit')->name('questionEdit');
    Route::get('question-delete/{id}', 'Admin\QuestionController@questionDelete')->name('questionDelete');

});
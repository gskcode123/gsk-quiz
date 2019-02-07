<?php

Route::group(['middleware' => ['auth','admin','lang']], function() {
    Route::get('/', 'Admin\DashboardController@adminDashboardView')->name('adminDashboardView');
    Route::get('/search', 'Admin\DashboardController@qsSearch')->name('qsSearch');

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
    Route::get('user-make-admin/{id}', 'Admin\UserController@userMakeAdmin')->name('userMakeAdmin');
    Route::get('user-make-user/{id}', 'Admin\UserController@userMakeUser')->name('userMakeUser');

    //Question Category
    Route::get('question-category-list', 'Admin\CategoryController@qsCategoryList')->name('qsCategoryList');
    Route::get('question-category-create', 'Admin\CategoryController@qsCategoryCreate')->name('qsCategoryCreate');
    Route::post('question-category-save', 'Admin\CategoryController@qsCategorySave')->name('qsCategorySave');
    Route::get('question-category-edit/{id}', 'Admin\CategoryController@qsCategoryEdit')->name('qsCategoryEdit');
    Route::get('question-category-delete/{id}', 'Admin\CategoryController@qsCategoryDelete')->name('qsCategoryDelete');
    Route::get('question-category-activate/{id}', 'Admin\CategoryController@qsCategoryActivate')->name('qsCategoryActivate');
    Route::get('question-category-deactivate/{id}', 'Admin\CategoryController@qsCategoryDeactivate')->name('qsCategoryDeactivate');

    //Question
    Route::get('question-list', 'Admin\QuestionController@questionList')->name('questionList');
    Route::get('category-question-list/{id}', 'Admin\QuestionController@categoryQuestionList')->name('categoryQuestionList');
    Route::get('question-create', 'Admin\QuestionController@questionCreate')->name('questionCreate');
    Route::post('question-save', 'Admin\QuestionController@questionSave')->name('questionSave');
    Route::get('question-edit/{id}', 'Admin\QuestionController@questionEdit')->name('questionEdit');
//    Route::get('question-delete/{id}', 'Admin\QuestionController@questionDelete')->name('questionDelete');
    Route::get('question-activate/{id}', 'Admin\QuestionController@questionActivate')->name('questionActivate');
    Route::get('question-deactivate/{id}', 'Admin\QuestionController@questionDectivate')->name('questionDectivate');

});
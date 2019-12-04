<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Installation
Route::get('/configuration', 'InstallationController@install')->name('installTheme');

Route::get('/system/check', 'InstallationController@system_check_process')->name('system-check');

Route::post('/configuration', 'InstallationController@theme_check_process')->name('install.theme');

Route::post('/install/settings', 'InstallationController@settings_process')->name('install.settings');

Route::get('/test', 'ApplicationController@test')->name('test');

// Elastic Search Test

Route::get('/addIndex', 'ApplicationController@addIndex')->name('addIndex');

Route::get('/addAll', 'ApplicationController@addAllVideoToEs')->name('addAll');

// CRON

Route::get('/publish/video', 'ApplicationController@cron_publish_video')->name('publish');


// Video upload 

Route::post('select/sub_category' , 'ApplicationController@select_sub_category')->name('select.sub_category');

Route::post('select/genre' , 'ApplicationController@select_genre')->name('select.genre');


Route::group(['prefix' => 'admin'], function(){

    Route::get('login', 'Auth\AdminAuthController@showLoginForm')->name('admin.login');

    Route::post('login', 'Auth\AdminAuthController@login')->name('admin.login.post');

    Route::get('logout', 'Auth\AdminAuthController@logout')->name('admin.logout');

    // Registration Routes...

    Route::get('register', 'Auth\AdminAuthController@showRegistrationForm');

    Route::post('register', 'Auth\AdminAuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\AdminPasswordController@showResetForm');

    Route::post('password/email', 'Auth\AdminPasswordController@sendResetLinkEmail');

    Route::post('password/reset', 'Auth\AdminPasswordController@reset');

    Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/profile', 'AdminController@profile')->name('admin.profile');

	Route::post('/profile/save', 'AdminController@profile_process')->name('admin.save.profile');

	Route::post('/change/password', 'AdminController@change_password')->name('admin.change.password');

    // users

    Route::get('/users', 'AdminController@users')->name('admin.users');

    Route::get('/add/user', 'AdminController@add_user')->name('admin.add.user');

    Route::get('/edit/user', 'AdminController@edit_user')->name('admin.edit.user');

    Route::post('/add/user', 'AdminController@add_user_process')->name('admin.save.user');

    Route::get('/delete/user', 'AdminController@delete_user')->name('admin.delete.user');

    Route::get('/view/user/{id}', 'AdminController@view_user')->name('admin.view.user');

    // User History - admin

    Route::get('/user/history/{id}', 'AdminController@view_history')->name('admin.user.history');

    Route::get('/delete/history/{id}', 'AdminController@delete_history')->name('admin.delete.history');
    
    // User Wishlist - admin

    Route::get('/user/wishlist/{id}', 'AdminController@view_wishlist')->name('admin.user.wishlist');

    Route::get('/delete/wishlist/{id}', 'AdminController@delete_wishlist')->name('admin.delete.wishlist');

    // Categories

    Route::get('/categories', 'AdminController@categories')->name('admin.categories');

    Route::get('/add/category', 'AdminController@add_category')->name('admin.add.category');

    Route::get('/edit/category/{id}', 'AdminController@edit_category')->name('admin.edit.category');

    Route::post('/add/category', 'AdminController@add_category_process')->name('admin.save.category');

    Route::get('/delete/category', 'AdminController@delete_category')->name('admin.delete.category');

    Route::get('/view/category/{id}', 'AdminController@view_category')->name('admin.view.category');

    Route::get('/category/approve', 'AdminController@approve_category')->name('admin.category.approve');

    // Admin Sub Categories

    Route::get('/subCategories/{category}', 'AdminController@sub_categories')->name('admin.sub_categories');

    Route::get('/add/subCategory/{category}', 'AdminController@add_sub_category')->name('admin.add.sub_category');

    Route::get('/edit/subCategory/{category_id}/{sub_category_id}', 'AdminController@edit_sub_category')->name('admin.edit.sub_category');

    Route::post('/add/subCategory', 'AdminController@add_sub_category_process')->name('admin.save.sub_category');

    Route::get('/delete/subCategory/{id}', 'AdminController@delete_sub_category')->name('admin.delete.sub_category');

    Route::get('/view/subCategory/{id}', 'AdminController@view_sub_category')->name('admin.view.sub_category');

    Route::get('/subCategory/approve', 'AdminController@approve_sub_category')->name('admin.sub_category.approve');
    
    
    // Stories
    Route::get('/stories', 'AdminController@stories')->name('admin.stories');
    Route::get('/add/story', 'AdminController@add_story')->name('admin.add.story');
    Route::get('/edit/story/{id}', 'AdminController@edit_story')->name('admin.edit.story');
    Route::post('/add/story', 'AdminController@add_story_process')->name('admin.save.story');
    Route::get('/delete/story', 'AdminController@delete_story')->name('admin.delete.story');
    Route::get('/view/story/{id}', 'AdminController@view_story')->name('admin.view.story');
    Route::get('/story/approve', 'AdminController@approve_story')->name('admin.story.approve');
    
    // Genre
    Route::post('/save/genre' , 'AdminController@save_genre')->name('admin.save.genre');

    Route::get('/genre/approve', 'AdminController@approve_genre')->name('admin.genre.approve');

    Route::get('/delete/genre/{id}', 'AdminController@delete_genre')->name('admin.delete.genre');

    Route::get('/view/genre/{id}', 'AdminController@view_genre')->name('admin.view.genre');

    // Videos

    Route::get('/videos', 'AdminController@videos')->name('admin.videos');

    Route::get('/add/video', 'AdminController@add_video')->name('admin.add.video');

    Route::get('/edit/video/{id}', 'AdminController@edit_video')->name('admin.edit.video');

    Route::post('/edit/video/process', 'AdminController@edit_video_process')->name('admin.save.edit.video');

    Route::get('/view/video', 'AdminController@view_video')->name('admin.view.video');

    Route::post('/add/video', 'AdminController@add_video_process')->name('admin.save.video');

    Route::get('/delete/video/{id}', 'AdminController@delete_video')->name('admin.delete.video');

    Route::get('/video/approve/{id}', 'AdminController@approve_video')->name('admin.video.approve');

    Route::get('/video/decline/{id}', 'AdminController@decline_video')->name('admin.video.decline');

    // Slider Videos

    Route::get('/slider/video/{id}', 'AdminController@slider_video')->name('admin.slider.video');

    
    // Settings

    Route::get('settings' , 'AdminController@settings')->name('admin.settings');
    
    Route::post('settings' , 'AdminController@settings_process')->name('admin.save.settings');

    Route::get('help' , 'AdminController@help')->name('admin.help');

    // Pages

    Route::get('/viewPage', array('as' => 'viewPages', 'uses' => 'AdminController@viewPages'));

    Route::get('/editPage/{id}', array('as' => 'editPage', 'uses' => 'AdminController@editPage'));

    Route::post('/editPage', array('as' => 'editPageProcess', 'uses' => 'AdminController@pagesProcess'));

    Route::get('/pages', array('as' => 'addPage', 'uses' => 'AdminController@add_page'));

    Route::post('/pages', array('as' => 'adminPagesProcess', 'uses' => 'AdminController@pagesProcess'));

    Route::get('/deletePage/{id}', array('as' => 'deletePage', 'uses' => 'AdminController@deletePage'));

    // Audition Routes
    Route::group(['prefix' =>'banner', 'as' => 'banner.'], function () {
        Route::get('/',['uses'=>'AuditionController@viewBanner','as'=>'view-banner']);
        Route::get('/add',['uses'=>'AuditionController@showBannerForm','as'=>'show-banner']);
        Route::post('/store',['uses'=>'AuditionController@addBanner','as'=>'add-banner']);

        Route::get('/edit/{id}',['uses'=>'AuditionController@showEditBannerForm','as'=>'edit-banner-form']);
        Route::post('/edit',['uses'=>'AuditionController@editBanner','as'=>'edit-banner']);
        Route::get('/delete/{id}',['uses'=>'AuditionController@deleteBanner','as'=>'delete-banner']);
    });

    Route::group(['prefix' =>'news', 'as' => 'news.'], function () {
        Route::get('/',['uses'=>'AuditionController@viewNews','as'=>'view-news']);
        Route::get('/add',['uses'=>'AuditionController@showNewsForm','as'=>'show-news-form']);
        Route::post('/store',['uses'=>'AuditionController@addNews','as'=>'add-news']);

        Route::get('/edit/{id}',['uses'=>'AuditionController@showEditNewsForm','as'=>'edit-news-form']);
        Route::post('/edit',['uses'=>'AuditionController@editNews','as'=>'edit-news']);
        Route::get('/delete/{id}',['uses'=>'AuditionController@deleteNews','as'=>'delete-news']);
    });

    Route::group(['prefix' =>'sponser', 'as' => 'sponser.'], function () {
        Route::get('/',['uses'=>'AuditionController@viewSponser','as'=>'view-sponser']);
        Route::get('/add',['uses'=>'AuditionController@showSponserForm','as'=>'show-sponser-form']);
        Route::post('/store',['uses'=>'AuditionController@addSponser','as'=>'add-sponser']);

        Route::get('/edit/{id}',['uses'=>'AuditionController@showEditSponserForm','as'=>'edit-sponser-form']);
        Route::post('/edit',['uses'=>'AuditionController@editSponser','as'=>'edit-sponser']);
        Route::get('/delete/{id}',['uses'=>'AuditionController@deleteSponser','as'=>'delete-sponser']);
    });

    Route::group(['prefix' =>'judge', 'as' => 'judge.'], function () {
        Route::get('/',['uses'=>'AuditionController@viewJudge','as'=>'view-judge']);
        Route::get('/add',['uses'=>'AuditionController@showJudgeForm','as'=>'show-judge']);
        Route::post('/store',['uses'=>'AuditionController@addJudge','as'=>'add-judge']);

        Route::get('/edit/{id}',['uses'=>'AuditionController@showEditJudgeForm','as'=>'edit-judge-form']);
        Route::post('/edit',['uses'=>'AuditionController@editJudge','as'=>'edit-judge']);
        Route::get('/delete/{id}',['uses'=>'AuditionController@deleteJudge','as'=>'delete-judge']);
    });

    Route::group(['prefix' =>'audition', 'as' => 'audition.','middleware' => 'admin'], function () {
        Route::get('/',['uses'=>'AuditionController@viewAllAuditionUser','as'=>'view-audition']);
        Route::get('/add',['uses'=>'AuditionController@showAuditionForm','as'=>'show-audition-form']);
        Route::post('/store',['uses'=>'AuditionController@addAudition','as'=>'add-audition']);

        Route::get('/edit/{id}',['uses'=>'AuditionController@showEditAuditionForm','as'=>'edit-audition-form']);
        Route::post('/edit',['uses'=>'AuditionController@editAudition','as'=>'edit-audition']);
        Route::get('/delete/{id}',['uses'=>'AuditionController@deleteAudition','as'=>'delete-audition']);

        //server integrate with merchant
//        Route::get('/khalti',['uses'=>'AuditionController@showKhalti','as'=>'view-khalti']);
//        Route::get('/integrate',['uses'=>'AuditionController@integrateKhalti','as'=>'delete-audition']);

        //spinner group
    });

    Route::group(['prefix' =>'location', 'as' => 'location.'], function () {
        Route::get('/',['uses'=>'AuditionController@viewAllAuditionLocation','as'=>'view-location']);
        Route::get('/add',['uses'=>'AuditionController@showAuditionLocationForm','as'=>'show-location']);
        Route::post('/store',['uses'=>'AuditionController@addLocation','as'=>'add-location']);

        Route::get('/edit/{id}',['uses'=>'AuditionController@showEditLocationForm','as'=>'edit-location-form']);
        Route::post('/edit',['uses'=>'AuditionController@editLocation','as'=>'edit-location']);
        Route::get('/delete/{id}',['uses'=>'AuditionController@deleteLocation','as'=>'delete-location']);

    });

    Route::group(['prefix'=>'spinner'],function(){
        Route::get('/landmark','SpinnerController@index')->name('landmark');
        Route::get('/landmark/create','SpinnerController@create')->name('addlandmark');
        Route::post('/landmark/store','SpinnerController@store')->name('storelandmark');
        Route::get('/landmark/delete/{landmark}','SpinnerController@destroy')->name('landmarkdelete');
    });


    //End Audition Routes

    //counter routes
    Route::get('/counter','CounterController@index')->name('counter');
    Route::get('/add/counter','CounterController@show')->name('addcounter');
    
    Route::post('/counter/{id?}','CounterController@store')->name('storecounter');
    
    Route::get('/counter/{id}','CounterController@destroy')->name('deletecounter');
    
    Route::get('/counter/edit/{id}','CounterController@show')->name('editcounter');
    Route::get('/user/earnings/{id}','TransactionController@index')->name('user-earnings');

    Route::get('app','AppController@index')->name('app');
    Route::get('app/create/{id?}','AppController@create')->name('createapp');

    Route::post('app/store','AppController@store')->name('storeapp');

    Route::get('app/delete/{id}','AppController@destroy')->name('appdelete');
   
    Route::get('/live-quiz-winners','LivequizController@getAllTimeWinners')->name('live-quiz-winners');
});

Route::get('/my-pay','PaymentController@myPay');




















//payment routes
Route::get('/payment',['uses'=>'PaymentController@selectPayment','as'=>'select-payment']);


//stripe integration

Route::group(['prefix' =>'stripe', 'as' => 'stripe.'], function () {
    Route::get('/',['uses'=>'PaymentController@paymentStripe','as'=>'view-stripe']);
    Route::post('/admin/integrate',['uses'=>'PaymentController@postPaymentStripe','as'=>'integrate-stripe']);
    Route::post('/user/integrate',['uses'=>'PaymentController@postUserPaymentStripe','as'=>'integrate-user-stripe']);

});
//end stripe integration


//server integrate with merchant

Route::group(['prefix' =>'khalti', 'as' => 'khalti.'], function () {
    Route::get('/',['uses'=>'AuditionController@showKhalti','as'=>'view-khalti']);
    Route::get('/integrate',['uses'=>'AuditionController@integrateKhalti','as'=>'integrate-khalti']);

});
//end khalti integration

//paypal integration
Route::group(['prefix' =>'paypal', 'as' => 'paypal.'], function () {
//    Route::post('/user/integrate',['uses'=>'PaymentController@postUserPaymentStripe','as'=>'integrate-user-stripe']);

    /*admin paypal*/
    Route::get('/',['uses'=>'PaymentController@paymentPaypal','as'=>'view-paypal'])->middleware('admin');
    Route::post('/admin/integrate',['uses'=>'PaymentController@paypalServerIntegration','as'=>'integrate-paypal'])/*->middleware('admin')*/;

});
//end paypal integratoin

Route::get('/', 'UserController@index')->name('user.dashboard');

Route::get('/single', 'UserController@single_video');

Route::get('/user/searchall' , 'ApplicationController@search_video')->name('search');

Route::any('/user/search' , 'ApplicationController@search_all')->name('search-all');

// Route::any('/user/search' , 'ApplicationController@search_all')->name('search-all');

// Categories and single video 

Route::get('categories', 'UserController@all_categories')->name('user.categories');

Route::get('category/{id}', 'UserController@category_videos')->name('user.category');

Route::get('subcategory/{id}', 'UserController@sub_category_videos')->name('user.sub-category');

Route::get('genre/{id}', 'UserController@genre_videos')->name('user.genre');

Route::get('video/{id}', 'UserController@single_video')->name('user.single');

Route::get('page/{type}', 'ApplicationController@get_page')->name('page');


Route::group([], function(){

    Route::get('login', 'Auth\AuthController@showLoginForm')->name('user.login.form');

    Route::post('login', 'Auth\AuthController@login')->name('user.login.post');

    Route::get('logout', 'Auth\AuthController@logout')->name('user.logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm')->name('user.register.form');

    Route::post('register', 'Auth\AuthController@register')->name('user.register.post');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');

    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');

    Route::post('password/reset', 'Auth\PasswordController@reset');

    Route::get('profile', 'UserController@profile')->name('user.profile');

    Route::get('update/profile', 'UserController@update_profile')->name('user.update.profile');

    Route::post('update/profile', 'UserController@profile_save')->name('user.profile.save');

    Route::get('/profile/password', 'UserController@profile_change_password')->name('user.change.password');

    Route::post('/profile/password', 'UserController@profile_save_password')->name('user.profile.password');

    // Delete Account

    Route::get('/delete/account', 'UserController@delete_account')->name('user.delete.account');

    Route::post('/delete/account', 'UserController@delete_account_process')->name('user.delete.account.process');


    Route::get('history', 'UserController@history')->name('user.history');

    Route::get('deleteHistory', 'UserController@delete_history')->name('user.delete.history');

    Route::post('addHistory', 'UserController@add_history')->name('user.add.history');

    // Wishlist

    Route::post('addWishlist', 'UserController@add_wishlist')->name('user.add.wishlist');

    Route::get('deleteWishlist', 'UserController@delete_wishlist')->name('user.delete.wishlist');

    Route::get('wishlist', 'UserController@wishlist')->name('user.wishlist');

    // Comments

    Route::post('addComment', 'UserController@add_comment')->name('user.add.comment');

    Route::get('comments', 'UserController@comments')->name('user.comments');
    
    Route::get('/trending', 'UserController@trending')->name('user.trending');

});


<?php

use Illuminate\Http\Request;


Route::group(['middleware'=>'api'], function(){
   Route::post('/login', 'Api\LoginController@login');


//audition api
    Route::group(['prefix' => 'audition/'], function(){
        //inserting form data
        Route::post('/registration', 'Api\AuditionController@storeAuditionForm');

        //listing the data
        Route::get('/banner/list', 'Api\AuditionController@getBannerlist');
        Route::get('/judge/list', 'Api\AuditionController@getJudgelist');
        Route::get('/sponser/list', 'Api\AuditionController@getSponserlist');
        Route::get('/location/list', 'Api\AuditionController@getLocationlist');
        Route::get('/news/list', 'Api\AuditionController@getNewslist');

        //Payment api
        Route::group(['prefix' => 'payment/'], function() {
            //stripe payment api
            Route::get('/stripe/key', 'Api\PaymentController@getStripeKey');

            Route::post('/stripe/pay', 'Api\PaymentController@postPaymentStripe');


            Route::post('/change/status', 'Api\PaymentController@changePaymentStatus')->middleware('jwt.verify');
            Route::get('/status', 'Api\AuditionController@getAuditionStatus');

            //offline  gundruk quiz change point
            Route::post('/change/status', 'Api\PaymentController@changePaymentStatus')->middleware('jwt.verify');


        });


    });
//end audition route

    //gundruk offline quiz api route
    Route::group(['prefix' => 'gundrukquiz/', 'middleware' => 'jwt.verify'], function() {
        //offline  gundruk quiz change point
        Route::post('/offline/change-point', 'Api\GundrukOfflineQuizController@addOfflineQuizPoint');
        Route::post('/offline/get-user-points', 'Api\GundrukOfflineQuizController@get_logged_in_user_points');
        Route::post('/offline/leaderboard', 'Api\GundrukOfflineQuizController@getLeaderBoard');
        
    });
});

Route::post('save-user-points','LeaderBoardController@save');
Route::get('get-user-points/{id}','LeaderBoardController@getPoints');
Route::get('leader-users','LeaderBoardController@get_leader_users');

Route::post('password-reset','LeaderBoardController@resetPassword');


Route::get('/stories', 'Api\GundrukController@getStoriesList');
Route::get('/videos', 'Api\GundrukController@getVideosList');
Route::get('/counter', 'Api\GundrukController@getCounter');
//to refresh the token
Route::post('/token/refresh', 'Api\LoginController@refresh');
Route::get('/policy', 'Api\GundrukController@getPolicy');
Route::get('/faq', 'Api\GundrukController@getFaq');








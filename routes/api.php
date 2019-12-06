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

    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::post('saveuserpoints','LeaderBoardController@save');
        Route::get('getuserpoints/{id}','LeaderBoardController@getPoints');
        Route::get('leaderusers','LeaderBoardController@get_leader_users');

        Route::post('deduct-user-point','LeaderBoardController@deductUserPoint');//params: user_id, point_to_deduct
        Route::post('register-live-user','LivequizController@registerLiveUsers');//params:question_set,user_id
        Route::post('save-live-data','LivequizController@store');//params: user_id, question_set, question_id, option,point,time_taken,prize
        Route::post('option-count','LivequizController@getOptionCount');//param:question_id
        Route::post('set-live-position','LivequizController@setPosition');//param:question_set,question_id
        Route::post('live-quit','LivequizController@quit');//param: user_id
        Route::post('add-live-viewer','LivequizController@setLiveViewer');//params:user_id, question_set
        
        
        Route::get('get-live-position','LivequizController@getPostion');
        Route::get('get-live-winner','LivequizController@getWinner');
        Route::get('get-winner-list','LivequizController@getWinnerList');
        
        Route::post('gundruk/payment-claim','LeaderBoardController@paymentClaim');

        Route::group(['prefix'=>'spinner/leaderboard'],function(){
            Route::post('/store','SpinnerLeaderboardController@store');
            Route::get('/top-ten','SpinnerLeaderboardController@topTenUsers');
            Route::get('/previous-winner','SpinnerLeaderboardController@previousWinners');
            Route::get('/user-point/{user_id}','SpinnerLeaderboardController@getUserPoint');
            Route::get('/get-landmark','SpinnerLeaderboardController@getLandmark');
            Route::post('/view-ad','SpinnerLeaderboardController@addSpin');
            
            Route::post('/check-in','SpinnerLeaderboardController@checkIn');
            Route::get('/check-in/{user_id}','SpinnerLeaderboardController@isCheckedIn');
            
        });

        Route::group(['prefix'=>'khalti/payment/'],function(){
            Route::post('/initiate','Api\KhaltiPaymentController@initiate');
            Route::post('/confirm','Api\KhaltiPaymentController@confirmation');
            Route::post('/card/verify','Api\KhaltiPaymentController@khaltiCardVerify');
        });
        
        Route::group(['prefix'=>'audition/payment'],function(){
            Route::get('/paypal/key','Api\PaymentController@getPaypalKey');
        });
        
    });
});
Route::get('get-winner-list','LivequizController@getWinnerList');
Route::post('save-user-points','LeaderBoardController@save');
Route::get('get-user-points/{id}','LeaderBoardController@getPoints');
Route::get('leader-users','LeaderBoardController@get_leader_users');
//apis for email signup
Route::post('send-topup','Api\LoginController@sendTopUp');
Route::post('password-reset','Api\LoginController@resetPassword');
Route::post('signup','Api\LoginController@signup');

Route::get('apps','AppController@api');

Route::get('/stories', 'Api\GundrukController@getStoriesList');
Route::get('/videos', 'Api\GundrukController@getVideosList');
Route::get('/counter', 'Api\GundrukController@getCounter');
//to refresh the token
Route::post('/token/refresh', 'Api\LoginController@refresh');
Route::get('/policy', 'Api\GundrukController@getPolicy');
Route::get('/payment-terms', 'Api\GundrukController@getPaymentTerms');
Route::get('/faq', 'Api\GundrukController@getFaq');




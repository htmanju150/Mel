<?php

Route::group(['middleware' => 'api', 'prefix' => 'leaveplan', 'namespace' => 'Modules\LeavePlan\Http\Controllers'], function()
{

    Route::group(['middleware' => 'jwt.auth'], function () {


        Route::post('DocLeaves', array('middleware' => 'cors','uses' =>'LeavePlanController@updateDocLeaves'));
        Route::post('GetDocLeaves', array('middleware' => 'cors','uses' =>'LeavePlanController@getDocLeaves'));
        Route::post('DeleteDocLeaves', array('middleware' => 'cors','uses' =>'LeavePlanController@deleteDocLeaves'));


    });

});

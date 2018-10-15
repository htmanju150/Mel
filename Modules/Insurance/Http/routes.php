<?php

Route::group(['middleware' => 'api', 'prefix' => 'insurance', 'namespace' => 'Modules\Insurance\Http\Controllers'], function()
{
    Route::group(['middleware' => 'jwt.auth'], function () {


        Route::post('DocInsurances', array('middleware' => 'cors','uses' =>'InsuranceController@updateDocInsurances'));
        Route::post('GetDocInsurances', array('middleware' => 'cors','uses' =>'InsuranceController@getDocInsurances'));
        Route::post('DeleteDocInsurances', array('middleware' => 'cors','uses' =>'InsuranceController@deleteDocInsurances'));


    });
});

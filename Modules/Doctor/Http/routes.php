<?php

Route::group(['middleware' => 'api', 'prefix' => 'doctor', 'namespace' => 'Modules\Doctor\Http\Controllers'], function()
{
    Route::post('register', 'APIRegisterController@registerUser');
    Route::post('login', 'APILoginController@login');
    Route::post('validateOtp', 'APIRegisterController@validateOtps');
    Route::post('forgotPassword', 'APIRegisterController@forgotPassword');
    Route::post('changePassword', 'APIRegisterController@changePassword');
    Route::post('checkCustomUrl', 'DoctorProfile@checkCustomUrl');



    Route::group(['middleware' => 'jwt.auth'], function () {


        Route::post('DoctorBio', array('middleware' => 'cors','uses' =>'DoctorProfile@updateDoctorBio'));
        Route::post('GetDocBio', array('middleware' => 'cors','uses' =>'DoctorProfile@getDoctorBio'));
        Route::post('ProfileImage', array('middleware' => 'cors','uses' =>'DoctorProfile@updateProfileImage'));
        Route::post('DocQualifications', array('middleware' => 'cors','uses' =>'DoctorProfile@updateDocQualifications'));
        Route::post('DocAccreditations', array('middleware' => 'cors','uses' =>'DoctorProfile@updateDocAccreditations'));
        Route::post('GetDocQualifications', array('middleware' => 'cors','uses' =>'DoctorProfile@getDocQualifications'));
        Route::post('GetDocAccreditations', array('middleware' => 'cors','uses' =>'DoctorProfile@getDocAccreditations'));
        Route::post('DeleteDocQualifications', array('middleware' => 'cors','uses' =>'DoctorProfile@deleteDocQualifications'));
        Route::post('DeleteDocAccreditations', array('middleware' => 'cors','uses' =>'DoctorProfile@deleteDocAccreditations'));
        Route::post('DocExperiences', array('middleware' => 'cors','uses' =>'DoctorProfile@updateExperiences'));
        Route::post('GetDocExperiences', array('middleware' => 'cors','uses' =>'DoctorProfile@getExperiences'));
        Route::post('DeleteExperiences', array('middleware' => 'cors','uses' =>'DoctorProfile@deleteExperiences'));
        Route::post('DocGovtId', array('middleware' => 'cors','uses' =>'DoctorProfile@updateGovtId'));
        Route::post('GetDocGovtId', array('middleware' => 'cors','uses' =>'DoctorProfile@getGovtId'));
        Route::post('DeleteDocGovtId', array('middleware' => 'cors','uses' =>'DoctorProfile@deleteGovtId'));

    });
});

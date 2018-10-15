<?php

Route::group(['middleware' => 'api', 'prefix' => 'publications', 'namespace' => 'Modules\Publications\Http\Controllers'], function()
{
    Route::group(['middleware' => 'jwt.auth'], function () {


        Route::post('GetPublications', array('middleware' => 'cors','uses' =>'PublicationsController@getPublications'));
        Route::post('Publications', array('middleware' => 'cors','uses' =>'PublicationsController@updatePublications'));
        Route::post('DeletePublications', array('middleware' => 'cors','uses' =>'PublicationsController@deletePublications'));


    });
});

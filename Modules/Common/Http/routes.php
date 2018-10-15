<?php

Route::group(['middleware' => 'api', 'prefix' => 'common', 'namespace' => 'Modules\Common\Http\Controllers'], function()
{
    Route::get('states', 'CommonController@getStates');
    Route::get('countries', 'CommonController@getCountries');
    Route::get('specializations', 'CommonController@getAllSpecializations');
    Route::get('policyProviders', 'CommonController@getAllPolicyProviders');

});

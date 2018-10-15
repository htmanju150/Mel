<?php

Route::group(['middleware' => 'web', 'prefix' => 'payments', 'namespace' => 'Modules\Payments\Http\Controllers'], function()
{
    Route::get('/', 'PaymentsController@index');
});

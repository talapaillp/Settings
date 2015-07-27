<?php

/*
|--------------------------------------------------------------------------
| Custom Settings Routes
|--------------------------------------------------------------------------
*/

// Admin Interface Routes
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()
{

	// Settings
	Route::resource('setting', 'SettingCrudController');

});
<?php

Route::group(array('before' => 'auth'), function()
{
	Route::get(ActionLog::$route.'/pages', array('as' => 'actionlog.pages.index', 'uses' => 'Vicimus\ActionLog\Controllers\PageController@index'));
	Route::get(ActionLog::$route.'/pages/raw', array('as' => 'actionlog.pages.raw', 'uses' => 'Vicimus\ActionLog\Controllers\PageController@raw'));
	Route::get(ActionLog::$route.'/pages/{category}', array('as' => 'actionlog.pages.category', 'uses' => 'Vicimus\ActionLog\Controllers\PageController@category'));

	Route::get(ActionLog::$route, 'Vicimus\ActionLog\ReportController@index');

	Route::get(ActionLog::$errorRoute.'/notifications', array('as' => 'actionlog.notify', 'uses' => 'Vicimus\ActionLog\Controllers\NotificationController@index'));
	Route::post(ActionLog::$errorRoute.'/notifications', array('as' => 'actionlog.config', 'uses' => 'Vicimus\ActionLog\Controllers\NotificationController@config'));
	Route::get(ActionLog::$errorRoute.'/notifications/{id}/edit', array('as' => 'actionlog.edit', 'uses' => 'Vicimus\ActionLog\Controllers\NotificationController@edit'));
	Route::post(ActionLog::$errorRoute.'/notifications/{id}/update', array('as' => 'actionlog.update', 'uses' => 'Vicimus\ActionLog\Controllers\NotificationController@update'));
	Route::get(ActionLog::$errorRoute.'/notifications/{id}/trashit', array('as' => 'actionlog.delete', 'uses' => 'Vicimus\ActionLog\Controllers\NotificationController@delete'));

	Route::get(ActionLog::$errorRoute, 'Vicimus\ActionLog\ReportController@errors');
	Route::get(ActionLog::$errorRoute.'/name/{action}', array('as' => 'actionlog.named', 'uses' => 'Vicimus\ActionLog\ReportController@named'));
	Route::get(ActionLog::$errorRoute.'/search', array('as' => 'actionlog.search', 'uses' => 'Vicimus\ActionLog\ReportController@search'));
	Route::get(ActionLog::$errorRoute.'/{id}', array('as' => 'actionlog.error', 'uses' => 'Vicimus\ActionLog\ReportController@error'));

	Route::post(ActionLog::$errorRoute.'/name/{action}', array('as' => 'actionlog.read', 'uses' => 'Vicimus\ActionLog\ReportController@read'));
});
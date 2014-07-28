<?php

Route::get(ActionLog::$route, 'Vicimus\ActionLog\ReportController@index');
Route::get(ActionLog::$errorRoute, 'Vicimus\ActionLog\ReportController@errors');
Route::get(ActionLog::$errorRoute.'/name/{action}', array('as' => 'actionlog.named', 'uses' => 'Vicimus\ActionLog\ReportController@named'));
Route::get(ActionLog::$errorRoute.'/search', array('as' => 'actionlog.search', 'uses' => 'Vicimus\ActionLog\ReportController@search'));
Route::get(ActionLog::$errorRoute.'/{id}', array('as' => 'actionlog.error', 'uses' => 'Vicimus\ActionLog\ReportController@error'));

Route::post(ActionLog::$errorRoute.'/name/{action}', array('as' => 'actionlog.read', 'uses' => 'Vicimus\ActionLog\ReportController@read'));

?>
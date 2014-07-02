<?php namespace Vicimus\ActionLog;

if(!defined('ACTIONLOG_REPORT_USER_DISPLAY'))
	define('ACTIONLOG_REPORT_USER_DISPLAY', 'email');

class ReportController extends \BaseController {

	public function index(){
		 
		$data = ActionLog::with('user')->orderBy('application')->get();
		return \View::make('actionlog::report.index', array('data' => $data));
	
	}

}

?>
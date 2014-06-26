<?php namespace Quintile\ActionLog;

class ReportController extends \BaseController {

	public function index(){
		
		//get lists of actionslogs based on application name
		

		$data = ActionLog::with('user')->orderBy('application')->get();
		return \View::make('actionlog::report.index', array('data' => $data));
	
	}

}

?>
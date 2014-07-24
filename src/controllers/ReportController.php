<?php namespace Vicimus\ActionLog;

if(!defined('ACTIONLOG_REPORT_USER_DISPLAY'))
	define('ACTIONLOG_REPORT_USER_DISPLAY', 'email');

class ReportController extends \BaseController {

	public function index(){
		 
		$data = ActionLog::with('user')->orderBy('application')->get();
		return \View::make('actionlog::report.index', array('data' => $data));
	
	}

	public function named($name)
	{
		$appName = (defined('APP_NAME')) ? APP_NAME : "Unspecified";

		$data = ActionLog::with('user')->
				where('application', '=', $appName)->
				where('action_name', '=', $name)->
				get();

		return \View::make('actionlog::report.named', compact('data'));
	}

	public function error($id)
	{

		$data = ActionLog::with('user')->find($id);
		return \View::make('actionlog::report.error', compact('data'));

	}

	public function errors()
	{
		$appName = (defined('APP_NAME')) ? APP_NAME : 'Unspecified';

		$packages = \DB::table('action_log')->
						select('package')->
						where('application', '=', $appName)->
						where('error', '=', true)->
						groupBy('package')->
						get();

		$data = array();
		foreach($packages as $pkg)
		{
			$actionNames = \DB::table('action_log')->
						select('action_name')->
						where('application', '=', $appName)->
						where('error', '=', true)->
						where('package', '=', $pkg->package)->
						groupBy('action_name')->
						get();


			foreach($actionNames as $action)
			{
				$data[$pkg->package][$action->action_name] = ActionLog::with('user')->
					where('package', '=', $pkg->package)->
					where('application', '=', $appName)->
					where('action_name', '=', $action->action_name)->
					where('error', '=', true)->
					count();
			}
		}	
		
		return \View::make('actionlog::report.errors', compact('data'));
	}

}

?>
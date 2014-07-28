<?php namespace Vicimus\ActionLog;

if(!defined('ACTIONLOG_REPORT_USER_DISPLAY'))
	define('ACTIONLOG_REPORT_USER_DISPLAY', 'email');

class ReportController extends \BaseController {

	public function index(){
		 
		$data = ActionLog::with('user')->orderBy('application')->get();
		return \View::make('actionlog::report.index', array('data' => $data));
	
	}

	public function read($name)
	{
		$appName = (defined('APP_NAME')) ? APP_NAME : "Unspecified";

		if(\Input::get('method') == "delete")
		{
			foreach(\Input::get('errors') as $id => $on)
			{
				$current = \Vicimus\ActionLog\ActionLog::find($id);
				$current->delete();
			}
		}
		elseif(\Input::get('method') == "mark")
		{
			if(!is_array(\Input::get('errors')))
			{
				$errors = \Vicimus\ActionLog\ActionLog::where('action_name', $name)->
							where('archive', false)->
							where('application', $appName)->get();
				foreach($errors as $err)
				{
					$err->archive = true;
					$err->save();
				}

				return \Redirect::back();
			}

			foreach(\Input::get('errors') as $id => $on)
			{
				$current = \Vicimus\ActionLog\ActionLog::find($id);
				$current->archive = true;
				$current->save();
			}
		}

		return \Redirect::back();
	}

	public function named($name)
	{
		$appName = (defined('APP_NAME')) ? APP_NAME : "Unspecified";

		$archived = (isset($_GET['archived']) && $_GET['archived'] == "true") ? true : false;

		$data = ActionLog::with('user')->
				where('application', '=', $appName)->
				where('action_name', '=', $name);

		if(!$archived)
			$data = $data->where('archive', false);
		$data = $data->orderBy('archive')->
				orderBy('created_at', 'DESC')->
				paginate(10);

		return \View::make('actionlog::report.named', compact('data'));
	}

	public function error($id)
	{

		$data = ActionLog::with('user')->find($id);
		$data->archive = true;
		$data->save();
		return \View::make('actionlog::report.error', compact('data'));

	}

	public function search()
	{
		$search = \Input::get('search');
		$archives = (\Input::get('search_archives') == "on") ? true : false;

		$search = explode(",", $search);
		$results = ActionLog::where('error', true);

		if(!$archives)
			$results = $results->where('archive', false);
		
		foreach($search as $term)
		{
			$results = $results->where('notes', 'LIKE', '%'.$term.'%');
		}

		$results = $results->paginate(10);
		$data = $results;
		return \View::make('actionlog::report.named', compact('data'));

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
<?php

namespace Vicimus\ActionLog\Models;

class PageView extends \Eloquent
{
	protected $table = 'action_page';
	protected $guarded = array();

	public static function Log()
	{

		//We want to ignore assets by default
		if(!\DealerLive\Config\Helper::check('action_page_assets') == 'true')
			if(\Request::segment(1) == "assets")
				return;
		

		//We want to ignore 404s because these can be caused behind the scenes in resource requests or ajax calls.
		if(!\DealerLive\Config\Helper::check('action_page_404') == 'true')
			if(\Request::segment(1) == "404")
				return;
		

		$session_id = \Session::getId();
		$route = \Request::path();
		$request_id = self::getRequestId();
		$category = self::getCategory();

		//Check to see if the user has visited the current route yet this session
		$log = PageView::where('session_id', $session_id)->where('route', $route)->first();
		if($log)
		{
			$log->views++;
			$log->save();
		}
		else
		{
			$log = new PageView();
			$log->application = (defined('APP_NAME')) ? APP_NAME : 'Unspecified';
			$log->session_id = $session_id;
			$log->user_id = (\Auth::check()) ? \Auth::user()->id : null;
			$log->route = $route;
			$log->request_id = $request_id;
			$log->views = 1;
			$log->category = $category;
			$log->save();
		}
	}

	public static function getRequestId()
	{
		return \Request::segment(3);
	}

	public static function getCategory()
	{
		return \Request::segment(1);
	}
}
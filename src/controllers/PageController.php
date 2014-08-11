<?php

namespace Vicimus\ActionLog\Controllers;

class PageController extends \BaseController
{
	public function index()
	{
		$pageData = \DB::table('action_page')->
						select(\DB::raw('route, SUM(views) as total_views'))->
						groupBy('route')->
						orderBy('total_views', 'DESC');

		if(\DealerLive\Config\Helper::check('action_page_404') != 'true')
			$pageData = $pageData->where('route', '!=', '404');

		if(\DealerLive\Config\Helper::check('action_page_post') != 'true')
			$pageData = $pageData->where('method', '!=', 'POST');

		if(\DealerLive\Config\Helper::check('action_page_assets') != 'true')
			$pageData = $pageData->where('route', 'NOT LIKE', 'assets%');

		if(\DealerLive\Config\Helper::check('action_page_admin') == 'true')
		{
			$users = \Role::find(\DB::table('roles')->select('id')->where('name', 'Super Admin')->first()->id)->users()->get();
			$ids = array();
			foreach($users as $u)
			{
				$ids[] = $u->id;
			}

			$pageData = $pageData->whereNotIn('user_id', $ids);
		}
			


		$pageData = $pageData->get();

		return \View::make('actionlog::pages.index', compact('pageData'));
	}

	public function category($category)
	{
		$pageData = \DB::table('action_page')->
						select(\DB::raw('route, request_id, SUM(views) as total_views'))->
						where('category', 'inventory')->
						groupBy('request_id')->
						orderBy('total_views', 'DESC');

		//Insert conditionals here

		$pageData = $pageData->get();

		$vehicles = array();
		foreach($pageData as $page)
		{
			$v = \DealerLive\Inventory\Models\Vehicle::find($page->request_id);
			if($v)
			{
				$v->url = $page->route;
				$v->views = $page->total_views;
				$vehicles[] = $v;
			}
		}

		$pageData = $vehicles;

		return \View::make('actionlog::pages.category', compact('pageData'));
	}

	public function raw()
	{
		$pageData = \Vicimus\ActionLog\Models\PageView::orderBy('updated_at', 'DESC')->get();

		//Could insert conditionals here, but since it's a raw view, may want to just
		//display everything no matter what their settings are.

		return \View::make('actionlog::pages.raw', compact('pageData'));
	}
}
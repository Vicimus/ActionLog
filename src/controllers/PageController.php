<?php

namespace Vicimus\ActionLog\Controllers;

class PageController extends \BaseController
{
	public function index()
	{
		$report = new \DealerLive\Reporting\Models\ReportReference(null, null, null, null, null);

		$report->data = \Vicimus\ActionLog\Models\PageView::getPageViews(new \DateTime('January 1, 1901'));
		$report->heading = "Page Views";
		$report->size = 12;

		$data = \View::make('Reporting::reports.table', compact('report'));
		return \View::make('actionlog::pages.index', compact('data'));
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
		$pageData = \Vicimus\ActionLog\Models\PageView::orderBy('route')->get();

		//Could insert conditionals here, but since it's a raw view, may want to just
		//display everything no matter what their settings are.

		return \View::make('actionlog::pages.raw', compact('pageData'));
	}
}
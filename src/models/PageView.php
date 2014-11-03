<?php

namespace Vicimus\ActionLog\Models;

class PageView extends \Eloquent
{
	protected $table = 'action_page';
	protected $guarded = array();

	
	public static function Log($page_id)
	{
		$pv = new PageView();
		$pv->session_id = \Session::getId();
		$pv->page_id = $page_id;

		if(class_exists('\DealerLive\Cms\CmsmlServiceProvider'))
			$pv->locale = \App::getLocale();

		$pv->save();
	}

	public function page()
	{
		$this->hasOne('\DealerLive\Cms\Models\Page');
	}

	public static function getPageViews(\DateTime $start = null, \DateTime $end = null)
	{
		if(is_null($start))
			$start = new \DateTime();
		
		if(is_null($end))
			$end = new \DateTime();

		$start = $start->format('Y-m-d');
		$end = $end->add(new \DateInterval('P01D'))->format('Y-m-d');

		if(class_exists('\DealerLive\Cms\CmsmlServiceProvider'))
			$locale = \App::getLocale().'_';
		else
			$locale = null;

		$views = \DB::table('action_page AS a')->
						select(\DB::raw('p.name as page_name, p.url as page_url, count(*) as views'))->
						join($locale.'cms_pages AS p', 'page_id', '=', 'p.id')->
						whereBetween('a.created_at', array($start, $end));

		if(class_exists('\DealerLive\Cms\CmsmlServiceProvider'))
			$views = $views->where('a.locale', \App::getLocale());

		$views = $views->groupBy('page_id')->orderBy('views', 'DESC')->get();

		return $views;
	}

	public static function reportPageViews($daily = false, $start = null, $end = null)
	{
		if($daily)
		{
			$start = new \DateTime('Yesterday');
			$end = new \DateTime('Yesterday');
		}

		if(!$daily && is_null($start))
			$start = new \DateTime('1900-01-01');
		if(!$daily && is_null($end))
			$end = with(new \DateTime())->add(new \DateInterval('P01D'));

		$data = self::getPageViews($start, $end);
		return $data;
	}
}
<?php

namespace Vicimus\ActionLog\Models;

class VehicleView extends \Eloquent
{
	protected $table = 'action_page_vehicle';
	protected $guarded = array();

	public static function Log($vehicle_id)
	{
		$vv = new VehicleView();
		$vv->session_id = \Session::getId();
		$vv->vehicle_id = $vehicle_id;
		$vv->save();
	}

	public function vehicle()
	{
		return $this->belongsTo('\DealerLive\Inventory\Models\Vehicle');
	}

	public static function getViewsByID($id)
	{
		return VehicleView::where('vehicle_id', $id)->count();
	}

	public static function getVehicleViews(\DateTime $start = null, \DateTime $end = null, $type = null)
	{
		if(is_null($start))
			$start = new \DateTime();
		
		if(is_null($end))
			$end = new \DateTime();
			
		$start = $start->format('Y-m-d');
		$end = $end->add(new \DateInterval('P01D'))->format('Y-m-d');

		$views = \DB::table('action_page_vehicle AS a')->
						select(\DB::raw('v.stock_number as stock, v.year as year, v.make as make, v.model as model, count(*) as views'))->
						join('vehicles AS v', 'vehicle_id', '=', 'v.id')->
						whereBetween('a.created_at', array($start, $end));
		if(!is_null($type))
		{
			$views = $views->where('v.type', $type);
		}

		$views = $views->groupBy('a.vehicle_id')->orderBy('views', 'DESC')->get();
		return $views;
	}

	public static function getModelViews(\DateTime $start = null, \DateTime $end = null)
	{
		if(is_null($start))
			$start = new \DateTime();
		
		if(is_null($end))
			$end = new \DateTime();

		$start = $start->format('Y-m-d');
		$end = $end->add(new \DateInterval('P01D'))->format('Y-m-d');

		$views = \DB::table('action_page_vehicle AS a')->
						select(\DB::raw('v.make as make, v.model as model, count(*) as views'))->
						join('vehicles AS v', 'vehicle_id', '=', 'v.id')->
						whereBetween('a.created_at', array($start, $end))->
						groupBy('v.model')->orderBy('views', 'DESC')->get();
		return $views;
	}

	public static function reportVehicleViews($daily = false, $start = null, $end = null)
	{

		if(!is_null($start))
			$start = new \DateTime($start);

		if(!is_null($end))
			$end = new \DateTime($end);

		if($daily)
		{
			$start = null;
			$end = null;
		}

		if(!$daily && is_null($start))
			$start = new \DateTime('1900-01-01');
		if(!$daily && is_null($end))
			$end = with(new \DateTime())->add(new \DateInterval('P01D'));
		

		$data = self::getVehicleViews($start, $end);
		return $data;
	}

	public static function reportModelViews($daily = false, $start = null, $end = null)
	{
		if($daily)
		{
			$start = null;
			$end = null;
		}

		if(!$daily && is_null($start))
			$start = new \DateTime('1900-01-01');
		if(!$daily && is_null($end))
			$end = with(new \DateTime())->add(new \DateInterval('P01D'));


		$data = self::getModelViews($start, $end);
		return $data;
	}
	
}
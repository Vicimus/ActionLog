<?php

namespace Vicimus\ActionLog\Models;

class Subscription extends \Eloquent
{
	protected $table = 'action_log_sub';
	protected $guarded = array();

	public function included()
	{
		$results = array();
		$words = explode(',', $this->keywords);
		foreach($words as &$w)
		{
			$w = trim($w);
			if(substr($w, 0, 1) != '!')
				$results[] = $w;
		}

		return $results;
	}

	public function excluded()
	{
		$results = array();
		$words = explode(',', $this->keywords);
		foreach($words as &$w)
		{
			$w = trim($w);

			if(substr($w, 0, 1) == '!')
				$results[] = substr($w, 1);
		}

		return $results;
	}

	public function isMatch(\Vicimus\ActionLog\ActionLog $action)
	{
		$matches = \Vicimus\ActionLog\ActionLog::where('id', $action->id);

		if($this->route != '*' && strpos($this->route, '*'))
		{
			$this->route = str_replace('*', '%', $this->route);
			$matches = $matches->where('route', 'LIKE', $this->route);
		}
		elseif($this->route != '*' && $this->route)
			$matches = $matches->where('route', $this->route);

		foreach($this->included() as $keyword)
			$matches = $matches->where('notes', 'LIKE', '%'.$keyword.'%');

		foreach($this->excluded() as $keyword)
			$matches = $matches->where('notes', 'NOT LIKE', '%'.$keyword.'%');

		return ($matches->first());

	}

	public static function notification(\Vicimus\ActionLog\ActionLog $action)
	{
		$count = 0;
		$subs = self::all();
		foreach($subs as $s)
		{
			if($s->isMatch($action)){
				$s->notify($action);
				$count++;
			}	
		}
		return $count;
	}

	public function notify(\Vicimus\ActionLog\ActionLog $action)
	{
		\Mail::send('actionlog::notify.email', array('action' => $action), function($message){
			$message->to($this->email)->subject(\DealerLive\Config\Helper::check('store_name').' Error Notification');
		});
	}
}

?>
<?php namespace Vicimus\ActionLog;

class Application {

	public static function Distinct(){

		$results = \DB::table('action_log')->groupby('application')->get(array('application'));

		return $results;
	}
}
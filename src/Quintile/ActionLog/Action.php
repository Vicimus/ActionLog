<?php namespace Quintile\ActionLog;

class Action {

	public $name;
	public $package;
	public $track_post;
	public $match;
	public $extracted;
	public $wildcard;
	public $method;

	public function __construct($name = NULL, $package = NULL, $method = NULL)
	{
		$this->name = $name;
		$this->package = $package;
		$this->method = $method;
		$this->match = false;
		$this->extracted = NULL;
		$this->wildcard = NULL;
		$this->track_post = NULL;

	}

	public function IgnorePostData(){
		$this->track_post = false;
	}

	public function TrackPostData(){
		if(ActionLog::isIgnoringPostData())
			$this->track_post = true;
		else
			$this->track_post = NULL;
	}
	


}
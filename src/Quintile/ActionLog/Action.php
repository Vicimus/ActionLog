<?php namespace Quintile\ActionLog;

class Action {

	public $name;
	public $package;
	public $track_post;
	public $required_auth;
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
		$this->require_auth = false;

	}

	public function &RequireAuth($modify = true){
		$this->require_auth = $modify;
		return $this;
	}

	public function &IgnorePostData(){
		$this->track_post = false;
		return $this;
	}

	public function &TrackPostData(){
		if(ActionLog::isIgnoringPostData())
			$this->track_post = true;
		else
			$this->track_post = NULL;

		return $this;
	}
	


}
<?php namespace Quintile\ActionLog;

class Action {

	public $name;
	public $package;
	public $track_post;
	public $match;
	public $extracted;
	public $wildcard;

	public function __construct($name = NULL, $package = NULL)
	{
		$this->name = $name;
		$this->package = $package;
		$this->match = false;
		$this->extracted = NULL;
		$this->wildcard = NULL;

	}


	public function IgnorePostData(){
		$this->track_post = false;
	}
	


}
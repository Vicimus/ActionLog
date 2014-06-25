<?php namespace Quintile\ActionLog;

	class ActionLog extends \Eloquent {
		
		//For Eloquent
		protected $guarded = [ 'session_id', 'user_id' ];
		protected $table = 'action_log';
		
		//For storing Action Names
		static public $names = array();

		//Routing
		static public $route = "actionlog/report";

		static private $force = false;
		static private $track_post = true;
		static private $require_auth = false;

		public static function makeFromAction(Action $action){

			$al = new ActionLog();

			//Set the name of the application
			if(defined('APP_NAME'))
				$al->application = APP_NAME;
			else
				$al->application = "Unspecified";

			//Set the name of the package
			$al->package = $action->package;

			//Record the Session ID
			$al->session_id = \Session::getId();

			//Record the method (GET or POST)
			$al->method = $action->method;

			//Track the user if there is one logged in
			if(isset(\Auth::user()->id))
				$al->user_id = \Auth::user()->id;

			//Set the name of the action
			$al->action_name = $action->name;

			//Set the route (the URL)
			$al->route = \Request::path();

			//Set the POST data if not ignoring
			if(count($_POST) && ((self::$track_post && !isset($action->track_post) || (!self::$track_post && $action->track_post))))
			{	
				$post_data = $_POST;
				foreach($post_data as $key => &$value)
					if(stripos($key, 'password') !== false)
						$value = \Hash::make($value);

				$al->post_data .= json_encode($post_data);
			}

			//Set the GET data if wildcard was present
			if(count($action->extracted) && (self::$track_post && $action->track_post))
				$al->post_data .= json_encode($action->extracted);

			return $al;
		}

		public function hasNoMatch(){
			if($this->package == 'NULL')
				return false;
			return true;
		}

		public function hasMatch(){
			return !$this->hasNoMatch();
		}

		public static function Log(){

			//This stops it from recording into the database on uses of ARTISAN
			if(!array_key_exists('HTTP_HOST', $_SERVER)) return false;

			$action = self::get();

			if($action->match || self::$force)
			{	
				if(
					(ActionLog::$require_auth && !\Auth::check() && $action->require_auth) || 
					
					($action->require_auth && !\Auth::check())
					
				)
				return false;

				$log = self::makeFromAction($action);
				$log->save();
			}

			return true;

		}

		public static function isIgnoringPostData(){
			return !self::$track_post;
		}

		public static function &register($package, $path, $method, $name)
		{
		
			self::$names[$path][$method] = new Action($name, $package, $method);
			return self::$names[$path][$method];
		}

		public static function get($path = NULL, $method = NULL)
		{

			//If path or method are not passed in
			//assign the request path and method
			//This means that an empty get() request
			//attempts to get the current path and current method
			if(!$path) $path = \Request::path();
			if(!$method) $method = \Request::method();

			//Replace numbers with an *
			//this allows for wildcard names
			//Just put '*' wherever a number would be when registering the name
			//Ex: (" home/user/edit/* ")
			//Also extracts the value it's replacing to store in the log
			preg_match('/[0-9]+/', $path, $extract);
			$extract = intval(implode('', $extract));
			$path = preg_replace('/[0-9]+/', '*', $path);

			//This looks for word-based wildcards. You can
			//register something like, " home/noun/* "
			//and this chunk of code will look at the path and if it finds
			//something like " home/noun/action " it will replace ACTION with *
			//thus matching it and returning a name.
			$components = explode('/', $path);
			$wildcard = $components[count($components)-1];
			$components[count($components)-1] = '*';
			$alternative = implode('/', $components);
			
			//Attempt to find a match within the registered names
			$results = self::findMatch($path, $method);
			$results->extracted = (empty($extract)) ? null : array('GET' => $extract);
			
			//If the find fails to find something, it's going to attempt to 
			//replace the wildcard, and search again. Doing it in this order stops
			//certain issues, like " home/noun/action/something " would be replaced
			//with " home/noun/*/something " in the alternative, and wouldn't be found
			//as a match, so it needs to search for the unmodified name first.
			//This also means you could register " home/noun/specific " AND " home/noun/* "
			//and it would try to match the first, and fallback to the second if nothing was found.
			$alt_results = new Action();
			if(!$results->match)
			{
				$alt_results = self::findMatch($alternative, $method);
				$alt_results->wildcard = $wildcard;
				$alt_results->extracted = (empty($extract)) ? null : array('GET' => $extract);
			}

			//Sends back the wildcard match if it was matched, otherwise send back the original,
			//which will contain some default values if no match was found.
			return (isset($alt_results->match) && $alt_results->match) ? $alt_results : $results;
		}

		private static function &findMatch($path, $method){

			//Default action
			$results = new Action($path."_".$method, 'NULL');

			//Find the correct action
			if(array_key_exists($path, self::$names))
			{
				if(array_key_exists($method, self::$names[$path]))
				{
					$results = self::$names[$path][$method];
					$results->match = true;
				}
			}

			return $results;
		}

		public static function LogEverything(){
			self::$force = true;
			//return new ActionLog();
		}

		public static function IgnorePostData(){
			self::$track_post = false;
			//return new ActionLog();
		}

		public static function RequireAuth(){
			self::$require_auth = true;
			//return new ActionLog();
		}
	}

?>
<?php namespace Vicimus\ActionLog;

use Illuminate\Support\ServiceProvider;
use \DealerLive\Reporting\Models\ReportReference;

class ActionLogServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('vicimus/actionlog');

		if(defined('\ACTIONLOG_ROUTE_PREFIX'))
			ActionLog::$route = \ACTIONLOG_ROUTE_PREFIX.ActionLog::$route;

		include __DIR__.'/../../routes.php';

		\Event::listen('ActionLog.Log', function(){
			ActionLog::Log();
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['actionlog'] = $this->app->share(function($app)
		{
			return new ActionLog;
		});

		//'View Log Report::'.\URL::to(ActionLog::$route) => 'made_up_thing',

		\Event::listen('ui.navigation.after', function() {
			\Navigation::assemble(
				array(
					'<i class="fa fa-file-text-o"></i> Action Log::#::made_up_thing' => array( // Parent Navigation Item
						'View Page Data::'.\URL::to(ActionLog::$route.'/pages') => 'blerg',
						'View Error Log::'.\URL::to(ActionLog::$errorRoute) => 'blerp',
						'Notifications::'.\URL::to(ActionLog::$errorRoute.'/notifications') => 'blerg',
						),
				)
			);
		}, 40);

		\Event::listen('config.nav', function(){
			\DealerLive\Config\Helper::assemble_nav('Page Views::'.\URL::to('dashboard/config/pageviews'), 'dev');
		}, 1);


		\Event::listen('reporting.types', function(){
			return new ReportReference(
				'\Vicimus\ActionLog\Models\PageView',
				null,
				"table",
				"reportPageViews",
				"Daily Page Views Report",
				array('nodates'));
		});

		\Event::listen('reporting.types', function(){
			return new ReportReference(
				'\Vicimus\ActionLog\Models\VehicleView',
				array(false),
				'table',
				'reportVehicleViews',
				'Vehicle View Report'
				);
		});

		\Event::listen('reporting.types', function(){
			return new ReportReference(
				'\Vicimus\ActionLog\Models\VehicleView',
				array(true),
				'table',
				'reportVehicleViews',
				'Daily Vehicle View Report',
				array('nodates')
				);
		});

		\Event::listen('reporting.types', function(){
			return new ReportReference(
				'\Vicimus\ActionLog\Models\VehicleView',
				array(true),
				'table',
				'reportModelViews',
				'Daily Model View Report',
				array('nodates')
				);
		});

		\Event::listen('reporting.types', function(){
			return new ReportReference(
				'\Vicimus\ActionLog\Models\VehicleView',
				array(false),
				'table',
				'reportModelViews',
				'Model View Report'
				);
		});

	}

	public function provides()
	{
		return array('actionlog');
	}

}

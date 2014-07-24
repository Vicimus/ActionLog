<?php namespace Vicimus\ActionLog;

use Illuminate\Support\ServiceProvider;

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
						'View Error Log::'.\URL::to(ActionLog::$errorRoute) => 'blerp'
						),
				)
			);
		}, 40);

		\Event::listen('reporting.types', function(){
			return new \DealerLive\Reporting\Models\ReportReference(
					"\Vicimus\ActionLog\ActionLog",
					null,
					"line",
					"getErrorFrequency",
					"Error Frequency"
				);
		});


	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('actionlog');
	}

}

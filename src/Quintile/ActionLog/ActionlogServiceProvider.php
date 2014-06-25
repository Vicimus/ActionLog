<?php namespace Quintile\ActionLog;

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
		$this->package('quintile/actionlog');

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

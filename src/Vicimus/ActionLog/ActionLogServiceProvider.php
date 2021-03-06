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
		if(class_exists('\DealerLive\Core\Classes\Package'))
			\Event::fire('core.packages', array(new \DealerLive\Core\Classes\Package('Action Log', 'Vicimus/ActionLog')));

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
		include __DIR__.'/../../navigation.php';
		
		$this->app['actionlog'] = $this->app->share(function($app)
		{
			return new ActionLog;
		});

		//'View Log Report::'.\URL::to(ActionLog::$route) => 'made_up_thing',
		/*
		\Event::listen('ui.navigation.after', function() {
			\Navigation::assemble(
				array(
					'<i class="fa fa-file-text-o"></i> ActionLog::#::made_up_thing' => array( // Parent Navigation Item
						'View Page Data::'.\URL::to(ActionLog::$route.'/pages') => 'blerg',
						'View Error Log::'.\URL::to(ActionLog::$errorRoute) => 'blerp',
						'Notifications::'.\URL::to(ActionLog::$errorRoute.'/notifications') => 'blerg',
						),
				)
			);
		}, 40);*/

		if(class_exists('\DealerLive\Cms\Models\Page'))
		{
			\Event::listen('reporting.types', function(){
				return new ReportReference(
					'\Vicimus\ActionLog\Models\PageView',
					array(true),
					"table",
					"reportPageViews",
					"Daily Page Views Report",
					array('nodates'));
			});

			\Event::listen('reporting.types', function(){
				return new ReportReference(
					'\Vicimus\ActionLog\Models\PageView',
					array(false),
					'table',
					'reportPageViews',
					'Page Views Report'
					);
			});
		}

		if(class_exists('\DealerLive\Inventory\Models\Vehicle'))
		{
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


			/*
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
			*/
			\Event::listen('reporting.types', function(){

	            $report = new ReportReference();

	            $report->setClass('\Vicimus\ActionLog\Models\VehicleView');
	            $report->setReport('reportVehicleViews');

	            $report->setType('table');

	            $report->setName('Daily New Vehicle View Report');
	            $report->setRules(array('nodates'));
	            $report->setParams(array('daily' => true, 'type' => 'new'));

	            return $report;
        	});

        	\Event::listen('reporting.types', function(){

	            $report = new ReportReference();

	            $report->setClass('\Vicimus\ActionLog\Models\VehicleView');
	            $report->setReport('reportVehicleViews');

	            $report->setType('table');

	            $report->setName('Daily Used Vehicle View Report');
	            $report->setRules(array('nodates'));
	            $report->setParams(array('daily' => true, 'type' => 'used'));

	            return $report;
        	});

        	\Event::listen('reporting.types', function(){
        		$report = new ReportReference();

        		$report->setClass('\Vicimus\ActionLog\Models\VehicleView');
        		$report->setReport('reportVehicleViews');

        		$report->setType('table');

        		$report->setName('MTD Vehicle Views');
        		$report->setRules(array('nodates'));

        		$start = with(new \DateTime())->modify('first day of this month')->format('Y-m-d');
        		$end = with(new \DateTime('Yesterday'))->format('Y-m-d');
        		$report->setParams(array('daily' => true, 'start' => $start, 'end' => $end));

        		return $report;
        	});

        	\Event::listen('reporting.types', function(){
        		$report = new ReportReference();

        		$report->setClass('\Vicimus\ActionLog\Models\VehicleView');
        		$report->setReport('reportVehicleViews');

        		$report->setType('table');

        		$report->setName('MTD New Vehicle Views');
        		$report->setRules(array('nodates'));

        		$start = with(new \DateTime())->modify('first day of this month')->format('Y-m-d');
        		$end = with(new \DateTime('Yesterday'))->format('Y-m-d');
        		$report->setParams(array('daily' => true, 'start' => $start, 'end' => $end, 'type' => 'new'));

        		return $report;
        	});

        	\Event::listen('reporting.types', function(){
        		$report = new ReportReference();

        		$report->setClass('\Vicimus\ActionLog\Models\VehicleView');
        		$report->setReport('reportVehicleViews');

        		$report->setType('table');

        		$report->setName('MTD Used Vehicle Views');
        		$report->setRules(array('nodates'));

        		$start = with(new \DateTime())->modify('first day of this month')->format('Y-m-d');
        		$end = with(new \DateTime('Yesterday'))->format('Y-m-d');
        		$report->setParams(array('daily' => true, 'start' => $start, 'end' => $end, 'type' => 'used'));

        		return $report;
        	});

		}
		
		

	}

	public function provides()
	{
		return array('actionlog');
	}

}

### Action Log

Action Log has changed a lot since it was first created, and now serves two purposes.

* Error Logging (with Notifications)
* Page View Tracking

Error Logging
-------------

Add the following to your `app/start/global.php` file:

```php
App::error(function(Exception $exception, $code)
{
	//Only redirect and log in production
	if(Config::get('app.debug'))
		return;
	
    switch ($code)
    {
        default:
        	$generalMessage = "Unfortunately there was an error";
        	ActionLog::errorLog("Core", "General Error", $exception->getMessage(), $exception->__toString());
            return Response::view('404', array('message' => $generalMessage), 500);
    }
});
```

This enables the error logging. It doesn't record errors in debug mode (instead it will display the normal error pages). It records the error into the database, and then redirects to the 404 view with the error message.

You can view the errors in the dashboard under `Action Log -> View Error Log`.

Notifications
-------------

You can subscribe to routes or keywords (in error messages) and be notified by email when these errors occur. These notifications can be setup through the dashboard under `Action Log -> Notifications`. The page contains instructions for creating notifications.

Page Views
----------

Add the following to your `app/filters.php` file:

```php
App::after(function($request, $response)
{
	\Event::fire('ActionLog.PageView');
});
```

This enables tracking of page views. There are some default options that restrict what is tracked, but these can be changed in the dashboard under `Configuration -> Page Views` and checking/unchecking whatever options you want.

By default:

* Requests for assets are ignored (css/js/image files)
* Requests for the 404 page are not recorded.
* Requests using the POST method are not recorded since a page isn't being displayed or explicitly requested by the user.
* Session IDs are shortened to help readability.
* Requests by the Super Admin are recorded but this can be disabled, as it can skew the data.

You can view the page view data through the dashboard under `Action Log -> View Page Data`
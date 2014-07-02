### ACTION LOG REGISTRATION 
	 	
For use in Laravel 4 applications.

Register any routes you'd like to log in your app/filters.php, inside App::before()

```php
  In App::after() place: 
 	Event::fire('ActionLog.Log');
```
 	
### USE 

```php
ActionLog::register( PACKAGE_NAME,  ROUTE,  GET || POST , NAME_FOR_ACTION ) ;
```
		
```
PACKAGE_NAME
```
This is if you want to track routes handled by other packages. You can give it
any name.

```
ROUTE
```
This is the route that's going to be tracked. Must be exactly as the route is defined.

```
GET || POST
```
Specify which method you'd like to track. Must be either 'GET' or 'POST'

NAME_FOR_ACTION
This is an easy to read name to summarize the action that's taking place. For example
if you were tracking the route that makes a user log into your application, you could name
		it "user_login", so when viewing data you know right away what that action was doing.



### OPTIONS
		
```php
ActionLog::LogEverything();
```

You can force the Log to record all actions:

Action's that have been registered will still be logged with those names, but
anything that doesn't match a name will be logged with the name:

```
ROUTE_METHOD (ie. 'dashboard/unicorns_GET' )
```


```php
ActionLog::IgnorePostData();
```

By default, if a POST method is being logged, it will insert the post
data into the database (with passwords hashed, and data json encoded).
You can stop this by calling IgnorePostData.

This should be placed above any registers for predictable results.

```php
ActionLog::register()->IgnorePostData();
```

You can set individual actions to ignore post data. For example in a blog,
if you wanted to generally capture post data (user registration, searches) but
didn't want to capture what could be large amounts of data (articles) you could
specifically ignore that action.

```php
ActionLog::register("package", "route", "POST", "post_blog")->IgnorePostData();

ActionLog::register()->TrackPostData();
```

If you've set ActionLog::IgnorePostData(), you can individually set registered
actions to Track Post Data. This is optimal if you want to ignore the majority
of actions post data, but want to track a few.

```php
ActionLog::RequireAuth();
```

This will ignore any routes, including those registered, if the current user is not
logged into your application.

```php
ActionLog::register()->RequireAuth();
```

This will tell that individual action to only record if the current user is logged in
to your application.

```php
ActionLog::register()->RequireAuth(false);
```

If the global ActionLog::RequireAuth() is set, calling this will force the action
to record even if the user isn't logged in to your application.

#### NOTE:

You can chain conditions on a register:

```php
ActionLog::register()->IgnorePostData()->RequireAuth();
```

If this was for a login form submission, it would no longer record
logs for failed submission attempts, and when an attempt succeeded, the
log would record without recording post data.

### REPORTS

The default route to view ActionLog reports is:

```
'actionlog/report'
```

You can hijack the default route for viewing the reports:

Add to your apps route folder:

```php
Route::get('WHATEVER', 'Quintile\ActionLog\ReportController@index');
```
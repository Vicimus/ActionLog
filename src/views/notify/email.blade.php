<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="{{ \DealerLive\Cms\Helpers::get_description(\Session::get('page_id')) }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{HTML::style('assets/css/bootstrap.css')}}
	</head>
	<body>
		<h3>Error Notification</h3>
		<p>An error that matched a subscription you created has just occurred. You can read more about this error here: <a href="{{\URL::route('actionlog.error', $action->id)}}">Error Specifics</a></p>
		<h4>Error Description</h4>
		<table class="table">
			<tbody>
				<tr>
					<td><strong>Route</srong></td>
					<td>{{$action->route}}</td>
				</tr>
				<tr>
					<td><strong>Notes</srong></td>
					<td>{{$action->notes}}</td>
				</tr>
				<tr>
					<td><strong>Stack Trace</srong></td>
					<td>{{$action->stack_trace}}</td>
				</tr>
			</tbody>
		</table>
	</body>

</html>
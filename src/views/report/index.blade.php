<html>
	<head>
		<title>ActionLog Report</title>
		 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		 <script src="{{ URL::asset('packages/quintile/actionlog/assets/js/report.js') }}"></script>
		 <link href="{{ URL::asset('packages/quintile/actionlog/assets/css/report.css') }}" rel="stylesheet">

		 <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
		 <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
	</head>
	<body>
@section('content')

<div id="navbar">
	<div class="title"><span class="strong">Action</span><span class="weak">Log</span></div>
	<div class="back"><a href="{{ URL::previous()}}">Return Back</a></div>
	<div style="clear: both; height: 0px"></div>
</div>

<div id="topbar">
	<div id="search">
		<label for="search_value">Search:</label>
		<input type="text" id="search_value" />
		<select id="search_type">
			<option value="all">All</option>
			<option value="app">Application</option>
			<option value="pkg">Package</option>
			<option value="actn">Action</option>
			<option value="session">Session</option>
			<option value="user">User</option>
			<option value="route">Route</option>
			<option value="method">Method</option>
			<option value="date">Date</option>
			<option value="data">Data</option>
		</select>
	</div>
	<div style="clear: both"></div>
</div>

<div id="report">
		<table class="report">
			<thead>
				<tr>
					<th class="app">Application</th>
					<th class="pkg">Package</th>
					<th class="actn">Action</th>
					<th class="session">Session ID</th>
					<th class="user">User</th>
					<th class="route">Route</th>
					<th class="method">Method</th>
					<th class="date">Date</th>
					<th class="data">Data</th>
				</tr>
			</thead>

			@foreach($data as $log)

			<tr class="row">
				<td class="app">{{ $log->application }}</td>
				<td class="pkg">{{ $log->package }}</td>
				<td class="actn">{{ $log->action_name }}</td>
				<td class="session" long="{{ $log->session_id }}" short="{{ substr($log->session_id, 0, 7) }}" hasShort="1"><a class="session_link" href="#">{{ substr($log->session_id, 0, 7) }}</a></td>
				@if($log->user_id == NULL)
					{{ "<td class='user'></td>" }}
				@else
				<?php $property = ACTIONLOG_REPORT_USER_DISPLAY; ?>
					{{ "<td class='user'>".$log->user->$property."</td>\n" }}
				@endif
				<td class="route">{{ $log->route }}</td>
				<td class="method">{{ $log->method }}</td>
				<td class="date">{{ $log->created_at }}</td>
				<td class="data">
					@if(isset($log->post_data))
						<a data='{{$log->post_data}}' class="post_data" logid="{{$log->id}}" showing="0">Preview</a>
					@endif
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@show

	</body>
</html>
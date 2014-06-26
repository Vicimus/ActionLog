@section('content')

		<table>
 
			<thead>
				<th>Application</th>
				<th>Package</th>
				<th>Session ID</th>
				<th>User</th>
				<th>Route</th>
				<th>Method</th>
				<th>Data</th>
			</thead>

			@foreach($data as $log)

			<tr>
				<td>{{ $log->application }}</td>
				<td>{{ $log->package }}</td>
				<td>{{ substr($log->session_id, 0, 7) }}</td>
				<td>
				@if($log->user_id == NULL)
					{{ "N/A"}}
				@else
					{{ $log->user->email }}
				@endif
			</td>
				<td>{{ $log->route }}</td>
				<td>{{ $log->method }}</td>
				<td>
					@if(isset($log->post_data))
						<a href="#">View</a>
					@endif

			</tr>
			@endforeach
		</table>
@show
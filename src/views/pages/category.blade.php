@extends('layouts/dashboard')

@section('title', 'ActionLog Page Views')
@section('breadcrumb', '')
@section('subtitle', 'Vehicle Page Data')

@section('title-right')
	
@stop

@section('content') 

<div class="row" style="padding: 20px 40px">

	@include('actionlog::pages.menu')->with('active', 'inventory')

	<div class="col-md-9">
		<table class="logtable">
			<thead>
				<tr>
					<th>Year</th>
					<th>Make</th>
					<th>Model</th>
					<th>URL</th>
					<th>Views</th>
				</tr>
			</thead>
			<tbody>
				@foreach($pageData as $vehicle)
				<tr>
					<td>{{$vehicle->year}}</td>
					<td>{{$vehicle->make}}</td>
					<td>{{$vehicle->model}}</td>
					<td><a href="{{\URL::to($vehicle->url)}}">Vehicle Page</a></td>
					<td>{{$vehicle->views}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop
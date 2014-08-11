@extends('layouts/dashboard')

@section('title', 'ActionLog Page Views')
@section('breadcrumb', '')
@section('subtitle', 'General Page Data')

@section('title-right')
	<a class="btn btn-primary pull-right" href="{{\URL::to('dashboard/config/pageviews')}}">Options</a>
@stop

@section('content') 

<div class="row" style="padding: 20px 40px">

	@include('actionlog::pages.menu')->with('active', 'index')

	<div class="col-md-9">
		<table class="logtable">
			<thead>
				<tr>
					<th>Route</th>
					<th>Views</th>
				</tr>
			</thead>
			<tbody>
				@foreach($pageData as $page)
				<tr>
					<td><a href="{{\URL::to($page->route)}}">{{$page->route}}</a></td>
					<td>{{$page->total_views}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop
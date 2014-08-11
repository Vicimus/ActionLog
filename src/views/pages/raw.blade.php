@extends('layouts/dashboard')

@section('title', 'ActionLog Page Views')
@section('breadcrumb', '')
@section('subtitle', 'Raw Page Data')

@section('title-right')
	
@stop

@section('content') 

<div class="row" style="padding: 20px 40px">

	@include('actionlog::pages.menu')->with('active', 'raw')

	<div class="col-md-9">
		<table class="logtable">
			<thead>
				<tr>
					<th>Category</th>
					<th>Session ID</th>
					<th>User</th>
					<th>Route</th>
					<th>Views</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@foreach($pageData as $page)
				<tr>
					<td>{{$page->category}}</td>
					<td>{{(\DealerLive\Config\Helper::check('action_page_session') != 'true') ? substr($page->session_id, 0, 9) : $page->session_id}}</td>
					<td>
						@if($page->user_id)
							{{\User::find($page->user_id)->email}}
						@else
							{{$page->user_id}}
						@endif
					</td>
					<td><a href="{{\URL::to($page->route)}}">{{$page->route}}</a></td>
					<td>{{$page->views}}</td>
					<td>{{$page->updated_at}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop
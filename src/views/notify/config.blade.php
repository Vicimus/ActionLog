@extends('layouts/dashboard')

@section('title', 'ActionLog Error Report')
@section('breadcrumb', 'ActionLog Error Report')
@section('subtitle', 'Subscriptions')

@section('title-right')
	
@stop

@section('content')   

<?php

	if(isset($data))
	{
		$subs = $data['subs'];
		$edit = $data['edit'];
	}

	$keywords = "";
	$route = (isset($_GET['r'])) ? $_GET['r'] : "";
	$email = (isset($_GET['r'])) ? \Auth::user()->email : "";
	$form = array('route' => 'actionlog.config');
	if(isset($edit))
	{
		$route = $edit->route;
		$email = $edit->email;
		$keywords = $edit->keywords;
		$form = array('route' => array('actionlog.update', $edit->id));

	}

?>


<div style="padding: 20px">
	<div class="row">

		<div class="col-md-2">
			<h3>Add</h3>
			{{ Form::open($form)}}

			<div class="form-group">
				<label>Email</label>
				<input type="text" class="form-control" name="email" required="required" value="{{$email}}" id="email" />
			</div>

			<div class="form-group">
				<label>Route</label>
				<input type="text" class="form-control" name="route" value="{{$route}}" />
			</div>

			<div class="form-group">
				<label>Keywords</label>
				<input type="text" class="form-control" name="keywords" value="{{$keywords}}" />
			</div>

			<div class="form-group">
				<button class="btn btn-primary" style="width: 100%">Subscribe</button>
			</div>

			{{ Form::close()}}
		</div>
		<div class="col-md-10">
			<div class="pull-right">
				<a class="btn btn-primary" href="{{\URL::route('actionlog.notify')}}">New Subscription</a>
			</div>
			<h3>Active Subscriptions</h3>
			@if(count($subs))
			<table class="table-condensed table table-bordered" style="background-color: #FFF" id="subs">
				<thead>
					<tr>
						<th style="padding: 1px"></th>
						<th style="padding: 1px"></th>
						<th style="padding: 4px">Route</th>
						<th style="padding: 4px">Email</th>
						<th style="padding: 4px">Keywords Included</th>
						<th style="padding: 4px">Keywords Excluded</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach($subs as $s)
						<tr>
							<td style="padding: 4px 2px; text-align: center">
								<a class="glyphicon glyphicon-edit" href="{{URL::route('actionlog.edit', $s->id)}}"></a>
							</td>
							<td style="padding: 4px 2px; text-align: center">
								<a class="glyphicon glyphicon-trash" href="{{URL::route('actionlog.delete', $s->id)}}" onclick="confirm('Are you sure you want to delete this subscription?')"></a>
							</td>
							<td style="width: 30%">{{$s->route}}</td>
							<td>{{$s->email}}</td>
							<td>
								<?php
								$count = 0;
								foreach($s->included() as $w)
								{
									echo $w;
									$count++;
									if($count < count($s->included()))
										echo ', ';
								}
								?>
							</td>
							<td>
								<?php
								$count = 0;
								foreach($s->excluded() as $w)
								{
									echo $w;
									$count++;
									if($count < count($s->excluded()))
										echo ', ';
								}
								?>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@else
				<div style="text-align: center">
					<h4>There are currently no subscriptions</h4>
				</div>
			@endif
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#email").focus();
	});
</script>
@stop
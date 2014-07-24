@extends('layouts/dashboard')

@section('title', 'ActionLog Error Report')
@section('breadcrumb', 'ActionLog Error Report')
@section('subtitle', 'ActionLog Error Report')

@section('title-right')
	
@stop

@section('content')   

<div class="container" style="margin-top: 20px">

<h2>Errors</h2>

@foreach($data as $package => $action)
<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">{{ucfirst($package)}}</h3>
  </div>
  <div class="panel-body">
  	<table style="width: 100%" class="table-condensed table-bordered">

  		<tbody>
  			
    		@foreach($action as $method => $error)
        <tr>
    			<td style="width: 60%">{{$method}}</td>
    			<td style="width: 20%">{{$error}} errors</td>
    			<td style="width: 20%"><a href="{{URL::route('actionlog.named', $method)}}">View Errors In Detail</a></td>
        </tr>
    		@endforeach
    	</tbody>
	</table>
  </div>
</div>
@endforeach
</div>

@stop
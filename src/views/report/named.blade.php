@extends('layouts/dashboard')

@section('title', 'ActionLog Error Report')
@section('breadcrumb', 'ActionLog Error Report')
@section('subtitle', 'ActionLog Error Report')

@section('title-right')
	
@stop

@section('content')   

<div class="container" style="margin-top: 20px">
<a href="{{URL::to(ActionLog::$errorRoute)}}"><button class="btn btn-default pull-right">Go Back</button></a>
<h2>Errors</h2>

<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">{{ucfirst($data[0]->package)." / ".$data[0]->action_name}}</h3>
  </div>
  <div class="panel-body">
  	<table style="width: 100%" class="table-condensed table-bordered">

  		<tbody>
  			<!-- didn't use TH/THEAD because the styling from the custom.css makes it look real ugly -->
  			<tr>
  				<td><strong>Route</strong></td>
  				<td><strong>User</strong></td>
  				<td><strong>Session</strong></td>
  				<td><strong>Date</strong></td>
  				<td>&nbsp;</td>
  			</tr>
  			@foreach($data as $error)
  			
  			<tr>
  				<td>{{$error->route}}</td>
  				<td>
              <?php
              if(isset($error->user))
                echo $error->user->email;
              else
                echo "";
              ?>
          </td>
  				<td>{{substr($error->session_id, 0, 9)}}</td>
  				<td>{{with(new DateTime($error->created_at))->format("F j, Y, g:i a")}}</td>
  				<td><a href="{{URL::route('actionlog.error', $error->id)}}">Detailed</a></td>
  			</tr>

  			@endforeach
    	</tbody>
	</table>
  </div>
</div>

</div>

@stop
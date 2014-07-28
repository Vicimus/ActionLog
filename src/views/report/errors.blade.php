@extends('layouts/dashboard')

@section('title', 'ActionLog Error Report')
@section('breadcrumb', 'ActionLog Error Report')
@section('subtitle', 'ActionLog Error Report')

@section('title-right')
	
@stop

@section('content')   

<div class="container" style="margin-top: 20px">
<div id="search_pane" style="width: 50%; float: right; margin-bottom: 20px; text-align: right">
  <form action="{{\URL::route('actionlog.search')}}" method="get" class="form-inline" id="search_form">
    <label>Search: <input type="text" class="form-control" style="font-weight: normal" name="search"><button class="btn btn-default">Search</button></label><br />
    <label><input type="checkbox" name="search_archives" checked="checked" /> Include Archived Errors</label>
  </form>
</div>
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
    			<td style="width: 20%">{{$error - \Vicimus\ActionLog\ActionLog::getArchivedErrorsByName($package, $method)}} new errors <span class="archived">/ {{\Vicimus\ActionLog\ActionLog::getArchivedErrorsByName($package, $method)}} archived</span></td>
    			<td style="width: 20%"><a href="{{URL::route('actionlog.named', $method)}}">View Errors In Detail</a></td>
        </tr>
    		@endforeach
    	</tbody>
	</table>
  </div>
</div>
@endforeach

@if(!count($data))
  <div style="text-align: center; clear: both">
    <h3>There are currently no errors!</h3>
    <h5>Congragulations on being awesome developers!</h5>
  </div> 

  <script type="text/javascript">

    $(document).ready(function(){
        $("#search_form input").prop('disabled', true);
        $("#search_form button").prop('disabled', true);
    });

  </script>
@endif
</div>

@stop
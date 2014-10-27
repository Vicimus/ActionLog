@extends('layouts/dashboard')

@section('title', 'ActionLog Error Report')
@section('breadcrumb', 'ActionLog Error Report')
@section('subtitle', 'ActionLog Error Report')

@section('title-right')
	
@stop

@section('content')  
<?php
//next and previous
$showArchives = (isset($_GET['archived']) && $_GET['archived'] == "true") ? true : false;

$next = $data->getNext($showArchives);
$previous = $data->getPrevious($showArchives);
$nextClass = "";
$previousClass = "";

if(!is_object($next))
{
  $next = '';
  $nextClass = " disabled";
}
else
    $next = \URL::route('actionlog.error', $next->id);

if(!is_object($previous))
{
  $previous = "";
  $previousClass = " disabled";
}
else
    $previous = \URL::route('actionlog.error', $previous->id);

 $archived = (isset($_GET['archived']) && $_GET['archived'] == "true") ? "?archived=true" : "";
?>
<div class="container" style="margin-top: 20px">
<div style="margin-bottom: 10px; text-align: right; width: 50%; float: right">
  <a href="{{$previous}}{{$archived}}" class="btn btn-default{{$previousClass}}">Previous Error</a> 
  <a href="{{$next}}{{$archived}}" class="btn btn-default{{$nextClass}}">Next Error</a> 
  <a href="{{\URL::route('actionlog.named', $data->action_name)}}{{$archived}}" class="btn btn-default">Go Back</a>
</div>
<h2>Errors</h2>

<div class="panel panel-danger">
  <div class="panel-heading">
     <div class="pull-right">{{with(new DateTime($data->created_at))->format("F j, Y, g:i a")}}</div>
    <h3 class="panel-title">Error #{{$data->id}} <small>(<a href="{{URL::route('actionlog.notify')}}?r={{$data->route}}" class="danger">Subscribe</a>)</small></h3>

  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-3">
        <h4>Application</h4>
        <p>{{$data->application}}</p>
      </div>
      <div class="col-md-3">
        <h4>Package</h4>
        <p>{{ucfirst($data->package)}}</p>
      </div>
      <div class="col-md-3">
        <h4>Class</h4>
        <p>{{$data->getClass()}}</p>
      </div>
      <div class="col-md-3">
        <h4>Method</h4>
        <p>{{$data->getMethod()}}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
          <h4>Session</h4>
          <p>{{substr($data->session_id, 0, 9)}}</p>
      </div>

      <div class="col-md-3">
          <h4>User</h4>
          @if($data->user === NULL)
            <p>N/A</p>
          @else
            <p>{{ucfirst($data->user->username)}}</p>
          @endif
      </div>

      <div class="col-md-6">
          <h4>Route</h4>
          <p><a href="{{URL::to('/')}}/{{$data->route}}">{{URL::to('/')}}/{{$data->route}}</a></p>
      </div>
    </div>
    <hr />
    <div class="row">
      <div class="col-md-6">
        <h4>Attempted Error Message To The User</h4>
        <p>{{($data->notes) ? $data->notes : "No message was displayed to the user."}}</p>
      </div>
      <div class="col-md-6">
        <h4>Post Data</h4>
        <p>
          <?php
            if($data->post_data)
            {
              $post = json_decode($data->post_data);
              
              ?>
              <table style="width: 100%" class="table-condensed table-bordered">
                <tr>
                  <td style="width: 40%"><strong>Property Name</strong></td>
                  <td style="width: 60%"><strong>Property Value</strong></td>
                </tr>
              @if(get_class($post) == 'stdClass')
                @foreach($post as $property => $value)
                  <tr><td>{{$property}}</td>
                  <td>
                      {{$value}}
                  </td>
                </tr>
                @endforeach
              @else
                <tr><td>{{$post}}</td></tr>
              @endif
            </table>
          <?php
            }
            else
            {
              $post = array();
              echo "No Post Data Present";
            }
          ?>
        </p>
      </div>
    </div>
    @if($data->stack_trace)
    <div class="row">
      <div class="col-md-12">
        <h4>Stack Trace</h4>
        <p>{{$data->stackTrace()}}</p>
      </div>
    </div>
    @endif

  </div>
</div>

</div>

@stop
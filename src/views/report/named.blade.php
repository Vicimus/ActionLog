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
    <?php
      $url = str_replace('%20', ' ', $_SERVER['REQUEST_URI']);
      $url = str_replace('%28', '(', $url);
      $url = str_replace('%29', ')', $url);
      $start = strrpos($url, '/') + 1;
      $end = strpos($url, '?');
      if(!$end) $end = strlen($url);
      $display = ucfirst(substr($url, $start, $end - $start));
      $checked = (isset($_GET['archived']) && $_GET['archived'] == "true") ? 'checked="checked"' : "";
      $archiveDisabled = (isset($_GET['search'])) ? ' disabled="disabled"' : '';
    ?>
    <label class="pull-right"><input type="checkbox" id="show_archives"{{$checked}}{{$archiveDisabled}} /> Show Archived Errors</label>
    <h3 class="panel-title">{{$display}}
      @if(isset($_GET['search']))
        {{': '.$_GET['search']}}
      @endif
    </h3>
  </div>
  <div class="panel-body">
    @if(!count($data))
      <div style="text-align: center"><h3>No Unread Errors In This Category</h3></div>
    @else
    <form action="{{URL::route('actionlog.read', $data->_name)}}" method="POST">
    	<table style="width: 100%; font-size: 12px;" class="table-condensed table-bordered table-striped">

    		<tbody>
    			<!-- didn't use TH/THEAD because the styling from the custom.css makes it look real ugly -->
    			<tr>
            <td id="checkTop"></td>
    				<td><strong>Route</strong></td>
    				<td><strong>Brief</strong></td>
    				<td><strong>Date</strong></td>
    				<td>&nbsp;</td>
    			</tr>
    			@foreach($data as $error)
          <?php
            $archive = ($error->archive) ? ' class="archived"' : "";
          ?>
    			<tr{{$archive}}>
            <td style="text-align: center; padding: 0"><input style="margin: 0 auto" type="checkbox" class="error_check" name="errors[{{$error->id}}]" /></td>
    				<td>{{$error->route}}</td>
    				<td>
                {{$error->brief()}}
            </td>
    				<td>{{with(new DateTime($error->created_at))->format("m/d/Y @ h:i a")}}</td>
            <?php
            $archived = (isset($_GET['archived']) && $_GET['archived'] == "true") ? "?archived=true" : "";
            ?>
    				<td style="text-align: center"><a href="{{URL::route('actionlog.error', $error->id)}}{{$archived}}"{{$archive}}>Detailed</a></td>
    			</tr>

    			@endforeach
      	</tbody>
  	</table>
    <div style="margin-top: 10px">
      <button id="mark_read" class="btn btn-primary btn-sm">Mark All As Read</button>
      <button id="delete" class="btn btn-danger btn-sm disabled">Delete Errors</button>
    </div>
    <div style="text-align: center; margin-top: 20px">
      @if(isset($_GET['archived']))
        <?php $data->appends(array('archived' => $_GET['archived'])); ?>
      @endif

      @if(isset($_GET['search']))
        <?php $data->appends(array('search' => $_GET['search'], 'search_archives' => $_GET['search_archives'])); ?>
      @endif
        {{$data->links()}}

    </div>
    <input type="hidden" name="method" id="method" />
  </form>
  @endif
  </div>
</div>

</div>

<script type="text/javascript">

  $(document).ready(function(){
    if($(".error_check:checked").length > 0)
      $("#delete").removeClass('disabled');
  });

  $("#checkTop").click(function(){
      $(".error_check").prop('checked', true);
      $("#delete").removeClass('disabled');
  });

  $(".error_check").click(function(){
      if($(".error_check:checked").length > 0)
      {
        $("#mark_read").text("Mark As Read");
        $("#delete").removeClass("disabled");
      }
      else
      {
        $("#mark_read").text("Mark All As Read");
        $("#delete").addClass("disabled");
      }
        
  });
  
  $("#mark_read").click(function(e){
    $("#method").val("mark");
      if($(".error_check:checked").length === 0)
      {
        if(!confirm("Are you sure you want to mark all unread errors as read?"))
            e.preventDefault();


      }
  });

  $("#show_archives").click(function(){
      if($("#show_archives").prop('checked'))
          window.location.href = "?archived=true";
      else
          window.location.href = "?archived=false";
  });

  $("#delete").click(function(e){ 
      if(!confirm("This will permanently delete these errors. Are you sure?"))
        e.preventDefault();

      $("#method").val("delete");
  });

</script>
@stop
@extends('layouts/dashboard')

@section('title', 'ActionLog Page Views')
@section('breadcrumb', '')
@section('subtitle', 'General Page Data')

@section('title-right')
@stop

@section('content') 

{{$data}}

<script type="text/javascript">
	$(document).ready(function(){
		$(".report-table th:last-child").css('text-align', 'right');
		$(".report-table td:last-child").css('text-align', 'right');
	});	
</script>

@stop

<?php
	
	$index = "";
	$inventory = "";
	$raw = "";

	if(isset($active) && $active == "index")
		$index = " active";
	elseif(isset($active) && $active == "inventory")
		$inventory = " active";
	elseif(isset($active) && $active == "raw")
		$raw = " active";
?>
	<div class="list-group pull-left col-md-3">
	  	<a href="{{\URL::route('actionlog.pages.index')}}" class="list-group-item{{$index}}" style="min-height: 82px">
	    	<h4 class="list-group-item-heading">General Page Data</h4>
	   		<p class="list-group-item-text">View general statistics on all pages, showing the most viewed pages, to the least viewed pages.</p>
	  	</a>
		
		<a href="{{\URL::route('actionlog.pages.category', 'inventory')}}" class="list-group-item{{$inventory}}" style="min-height: 82px">
	    	<h4 class="list-group-item-heading">Vehicle Page Data</h4>
	    	<p class="list-group-item-text">View information related to vehicle views, showing the most popular vehicles.</p>
	  	</a>
		
		<a href="{{\URL::route('actionlog.pages.raw')}}" class="list-group-item{{$raw}}" style="min-height: 82px">
	    	<h4 class="list-group-item-heading">Raw Page Data</h4>
	    	<p class="list-group-item-text">View the data as it appears in the database.</p>
	  	</a>
	</div>
<div class="container">
	<div class="row">
		<div class="col-md-12 options">
			<h2>Page View Options</h2>
			<p>The following are options that will effect how page views are tracked, and which requests are ignored.</p>
			<ul class="list-group" style="max-width: 50%; z-index: -999">
				<li class="list-group-item">
					<label style="width: 100%; height: 100%;">
					<input type="checkbox" id="action_page_assets" {{(\DealerLive\Config\Helper::check('action_page_assets')) ? 'checked="checked"' : ''}} /> 
						Record requests for assets <small>(css/js/images)</small></label>
				</li>
				<li class="list-group-item">
					<label style="width: 100%; height: 100%;">
						<input type="checkbox" id="action_page_404" {{(\DealerLive\Config\Helper::check('action_page_404')) ? 'checked="checked"' : ''}} /> 
						Record when users access the 404 page.</label>
				</li>
				<li class="list-group-item">
					<label style="width: 100%; height: 100%;">
						<input type="checkbox" id="action_page_post" {{(\DealerLive\Config\Helper::check('action_page_post')) ? 'checked="checked"' : ''}} /> 
						Record POST requests.</label>
				</li>
				<li class="list-group-item">
					<label style="width: 100%; height: 100%;"><input type="checkbox" id="action_page_session" {{(\DealerLive\Config\Helper::check('action_page_session')) ? 'checked="checked"' : ''}} /> 
						Show full Session IDs <small>(default shortened for readability)</small></label>
				</li>
				<li class="list-group-item">
					<label style="width: 100%; height: 100%;"><input type="checkbox" id="action_page_admin" {{(\DealerLive\Config\Helper::check('action_page_admin')) ? 'checked="checked"' : '' }} /> 
						Ignore page views from Super Admins. <small>(that's you)</small></label>
				</li>
			</ul>
				<input type="hidden" id="hidden_action_page_assets" name="config[action_page_assets]" />
				<input type="hidden" id="hidden_action_page_404" name="config[action_page_404]" />
				<input type="hidden" id="hidden_action_page_post" name="config[action_page_post]" />
				<input type="hidden" id="hidden_action_page_session" name="config[action_page_session]" />
				<input type="hidden" id="hidden_action_page_admin" name="config[action_page_admin]" />

		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$("input[type=checkbox").each(function(){
			var ele = $("#hidden_"+$(this).attr('id'));
			if($(this).prop('checked'))
				$(ele).val('true');
		});

		$("input[type=checkbox]").click(function(e){
			var ele = $("#hidden_"+$(this).attr('id'));
			if($(ele).val() == "")
				$(ele).val('true');
			else
				$(ele).val("");

		});	
	});
</script>
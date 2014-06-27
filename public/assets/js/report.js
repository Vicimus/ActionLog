var filtered = false;
var post_data = false;

$(document).ready(function(){
	
	

	$('td.session').mouseenter(function(){
		
		$(this).find('a:first').html($(this).attr('long'));
		$(this).attr('hasShort', '0');
		$(this).attr('class', 'session_enter')
	});

	$('td.session').mouseleave(function(){
		
		$(this).find('a:first').html($(this).attr('short'));
		$(this).attr('hasShort', '1');
		$(this).attr('class', 'session');
	});

	$('a.session_link').click(function(){
		var session_id = $(this).parent().attr('long');

		if(!filtered){
			$('td.session:not([long='+session_id+'])').parent().css('display', 'none');
			var post_data_table = $('tr.post_data[sessionid !='+session_id+']');
			if($(post_data_table).length > 0){
				$(post_data_table).each(function(index, value) {
					var link = $('a.post_data[logid='+$(value).attr('owner')+']');
					removePostDataTable($(link));
					$(link).text("Preview");
					$(link).attr("showing", '0');
				});
			}
			filtered = true;
		}
		else{
			$('td.session:not([long='+session_id+'])').parent().removeAttr('style');
			filtered = false;	
		}
	});

	$('a.post_data').mouseenter(function(){
		if($(this).attr('showing') === '0'){
			$(this).text("View");
			showPostDataTable($(this));
		}

	});

	$('a.post_data').mouseleave(function(){
		if($(this).attr('showing') === '0'){
			$(this).text("Preview");
			removePostDataTable($(this));
		}
	});

	$('a.post_data').click(function(){
		
		
		if($(this).attr('showing') !== '1'){
			
			//showPostDataTable($(this));
			$(this).text('Hide');
			$(this).attr('showing', '1');
		}
		else{

			removePostDataTable($(this));
			$(this).attr('showing', '0');
			$(this).text('Preview');
		}


	});

	$('#search_value').keyup(function(){
		var result = searchReport($(this).val(), $('#search_type').val());
		if(!result && $(this).val() != ''){
			if($('#notification').length)
				return false;
			var tbody = $("tbody");
			$("tbody").prepend("<tr id='notification'><td class='notification' colspan='8'>There were no matches to your search</td></tr>");
		}
		else{
			$('#notification').remove();
		}
	});
});

function searchReport(value, type){
	if(value == ''){
		$('tr.row').removeAttr('style');
		return false;
	}

	var match;

	if(type == "all")
		match = $('#report td:contains("'+value+'")').parent();
	else
		match = $('td.'+type+':contains("'+value+'")').parent();
	
	var not_match = $('tr.row').not(match);
		
	$(not_match).hide();
	$(match).show();
		
	if(match.length == 0)
		return false;
	else
		return true;
	
}

function removePostDataTable(current){
	$('tr.post_data[owner='+$(current).attr('logid')+']').remove();
	
}

function showPostDataTable(current){
	var parsed = JSON.parse($(current).attr('data'));
	var session_id = $(current).parent().parent().find('td.session').attr('long');
	var html = "<table class='sub_post_data'>";
	for(var propt in parsed){
		html += "<tr><td class='property sub_post_data'>" + propt + ":</td><td class='value sub_post_data'>" + parsed[propt] + "</td></tr>";
	}

	html += "</table>";
		
	var parent = $(current).parent().parent();
	var columns = $(parent).find('td').length;
	parent.after("<tr style='display: none' sessionid='"+session_id+"' class='post_data' owner='"+$(current).attr('logid')+"'><td class='post_data' colspan='"+columns+"'>"+html+"</td></tr>");
	var element = $('tr.post_data[sessionid='+session_id+']');
	$(element).fadeIn('fast');
		
}
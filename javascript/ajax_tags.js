function autocomplet0() {
	var min_length = 0; // min characters to display the autocomplete
	var tags = $('#search_id0').val();
	if (tags.length >= min_length) {
		$.ajax({
			url: 'ajax_tags_processing.php',
			type: 'POST',
			data: {tags:tags},
			success:function(data){
				$('#search_results0').show();
				$('#search_results0').html(data);
			}
		});
	} else {
		$('#search_results0').hide();
	}
}

function set_item(item) {
	$('#search_id0').val(item);
	$('#search_results0').hide();
}
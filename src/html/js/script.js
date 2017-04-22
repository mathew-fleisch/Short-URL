var clipboard = new Clipboard('#copy-btn');
// clipboard.on('success', function(e) {
//     console.info('Action:', e.action);
//     console.info('Text:', e.text);
//     console.info('Trigger:', e.trigger);

//     e.clearSelection();
// });

// clipboard.on('error', function(e) {
//     console.error('Action:', e.action);
//     console.error('Trigger:', e.trigger);
// });
$(document).ready(function() {
	console.log("ready");

	// Temporary event to build display first
	$(document).on('click', '#shrink', function() {
		var input = $('#long-url');
		if(isValidURL(input.val())) { 
			var url = encodeURIComponent($('#long-url').val());
			// console.log('url: ', decodeURIComponent(url));
			$('#short-url').val(decodeURIComponent(url));
			$('#output-container').slideDown(100);
		} else {
			console.error('Invalid url...');
			$('#errors').html(
				'<div class="alert alert-dismissible alert-danger">'
				  +'<button type="button" class="close" data-dismiss="alert">&times;</button>'
				  +'<strong>Oh snap!</strong> Invalid URL...'
				+'</div>'
			).slideDown(100);
		}
	});


	$(document).on('click', '#short-url-label', function() { $('#copy-btn').click(); });

});
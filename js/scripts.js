jQuery(document).ready(function($) {

	$('#submitTicket input[name="submitter"]').keypress(function (e) {
		var regex = new RegExp("^[a-zA-Z0-9]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}

		e.preventDefault();
		return false;
	});

	if ( $('#ticketTable').length !== 0 ) {
		if(window.location.hash) {
			var hash = window.location.hash.substring(1),
				hash = '#' + hash;

			$(hash).addClass('active');
		}
	}

	$('#ticketTable td select').each(function() {
		var column = $(this).parent().prop('className'),
			original = $('option.original', this),
			original_value = original.val();

		$(this).change(function() {
			
			var button = $('#ticketTable .edit-tickets').find('.' + column).find('button')

			if (!$('option:selected', this).hasClass('original')) {
				original.removeAttr('selected');
				$(this).parent().addClass('edited');
				button.show();
			} else {
				$(this).parent().removeClass('edited');
				if (!$('#ticketTable').find('.' + column + '.edited').length) {
					button.hide();
				}
			}	
			
		});
	});

	$('#ticketTable .edit-tickets button').each(function() {
		var column = $(this).parent().prop('className');

		$(this).click(function() {
			$('#ticketTable .' + column + '.edited').each(function() {
				var post_id = $(this).parent().attr('id'),
					changed_value = $(this).find('option:selected').val();

				$.ajax({
					type: 'POST',
					url: template_directory.templateUrl + '/template-parts/tickets/submit-ticket-changes.php',
					data: {
						id: post_id,
						column: column,
						value: changed_value,
					},
					success: function(data) {
						console.log(data);
						$(this).removeClass('edited');
					},
					error: function() {
						console.log('error!');
					},
				});	
			});
		})
	});

	function tableOverflow() {
		var containerWidth = $('#primary').outerWidth();

		console.log('Container Width is ' + containerWidth);

		$('table').each( function() {
			var tableWidth = $(this).outerWidth();
			console.log('Table Width is ' + tableWidth);

			if ( tableWidth > containerWidth ) {
				if ( !$(this).parent().is('.overflow-table') ) {
					$(this).wrap('<div class="overflow-table"></div>');
				}
				
			} else {
				if ( $(this).parent().is('.overflow-table') ) {
					$(this).upwrap();
				}
			}
		});
	}
	
	// Functions to call on page load
	tableOverflow();

	//Functions to call when window is resized
	jQuery(window).resize(function($) {
		tableOverflow();
	});

	//Functions to call when window is scrolled
	jQuery(window).scroll(function($) {
		
	});
	
});
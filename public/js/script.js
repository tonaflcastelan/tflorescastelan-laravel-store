/**
 * @author Tonatiuh Flores Castelán
 * @file script.js
 **/

$( document ).ready(function() {
	'use strict';
    
    $('#date_start').datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function (date) {
                var date_end = $('#date_end');
                var startDate = $(this).datepicker('getDate');
                var minDate = $(this).datepicker('getDate');
                date_end.datepicker('setDate', minDate);
                startDate.setDate(startDate.getDate() + 30);
                //sets dt2 maxDate to the last day of 30 days window
                date_end.datepicker('option', 'maxDate', startDate);
                date_end.datepicker('option', 'minDate', minDate);
                $(this).datepicker('option', 'minDate', minDate);
            }
        });

    $('#date_end').datepicker({dateFormat: 'yy-mm-dd'});

    $('#selectAll').click(function (e) {
	    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
	});	

    $('.delete-all, .delete-row').on('click', function(e) {
    	e.preventDefault();
    	var arrayProduct 	= [];  
    	var source 			= $(this).attr('data-source');
    	if (source == 2) {
    		arrayProduct.push($(this).attr('data-id'));
    	} else {
			$('.product_row:checked').each(function() {
				arrayProduct.push($(this).attr('data-id'));
			});
    	}

		if(arrayProduct.length <= 0) {
			$('#messages').html('');
			$('#messages').html('Please select row');
			$('#messages').addClass('alert alert-danger alert-block');
		} else {
			var selectedIDs = arrayProduct.join(','); 
			$.ajax({
				type: 'POST',
				url: 'products/delete',
				data: 'ids='+ selectedIDs,
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				success: function(response) {
					var 
						flag 	= response.success,
						message = response.message;
					if (flag) {
						$('#messages').html('');
						$('#messages').html(message);
						$('#messages').addClass('alert alert-success alert-block');
						location.reload();
					} else {
						$('#messages').html('');
						$('#messages').html(message);
						$('#messages').addClass('alert alert-danger alert-block');
					}
				}
			});
		}
	});
});
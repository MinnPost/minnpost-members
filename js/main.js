/**
MinnPost Members - 0.1.0
http://members.minnpost.com
Copyright (c) 2015 Jonathan Stegall
License: MIT
*/
/*jshint smarttabs:true */
// main members js

function differentAddressForShipping(checked) {
	if (checked === true) {
		$('.shipping_address').show();
	} else {
		$('.shipping_address').hide();
	}
}

function existingSubscription(status) {
if (status === 'existing') {
	$('.atlantic_id').show();
		$('.atlantic_id input').attr('required', 'required');
	} else {
		$('.atlantic_id').hide();
	}
}

function getFullAddress() {

	$('.not-geocomplete').addClass('offscreen');
	$('.use-geocomplete').show();

	/*$('#full_address').geocomplete({
	details: 'form',
	detailsAttribute: 'data-geo'
	});
	$('#full_address').click(function(){
	$('#full_address').trigger('geocode');
	});*/

	$('.geocomplete').click(function(){
		$(this).trigger('geocode');

		var attribute = $(this).closest('fieldset').attr('data-geo');

		$(this).geocomplete({
			details: 'form',
			detailsAttribute: attribute
		});

	});

}

function showOfferDetails() {
	if ($('.partner-offers li').length > 0) {
		$('.partner-offers li .details').hide();
		$('.partner-offers li').each(function() {
			var that = $(this);
			if ( $('.expand', $(this)).length > 0) {
				$('.expand', $(this)).click(function() {
					$('.details', that).toggle();
					return false;
				});
			}
		});
	}
}

/*$(function() {
	if (google.hasOwnProperty('maps')) {
		getFullAddress();
	}
	$('.use-geocomplete').hide();
});*/

$(document).ready(function() {

	differentAddressForShipping(false);
	$('#use_different_address').change(function() {
		var c = this.checked;
		differentAddressForShipping(c);
	});

	var atlantic_id = $('#atlantic_id').val();
	if(typeof atlantic_id !== 'undefined') {
		//alert('test');
		existingSubscription('existing');
	} else {
		existingSubscription('new');
	}
	$('form input[name=atlantic_status]').on('change', function() {
		var status = $('input[name=atlantic_status]:checked', 'form').val();
		existingSubscription(status);
	});

	showOfferDetails();

});
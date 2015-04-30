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

$(document).ready(function() {
	differentAddressForShipping(false);
	$('#use-account-address').change(function() {
		var c = this.checked;
    	differentAddressForShipping(c);
	});

	existingSubscription(false);
	$('form input[name=atlantic_status]').on('change', function() {
	   status = $('input[name=atlantic_status]:checked', 'form').val();
	   existingSubscription(status);
	});

});
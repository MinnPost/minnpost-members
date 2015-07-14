<?php
$message = '';
$message .= "MinnPost
========\r\n\r\n";

$message .= "Thank you for supporting MinnPost
---------------------------------\r\n\r\n";

if ($swag_status !== 'declined') {
	$message .= "We will send your MinnPost $swag_status to you as soon as possible.\r\n\r\n";
}

if ($atlantic_status !== 'declined') {
$message .= "We will submit a subscription request to The Atlantic on your behalf. That request will include the following information, which we received from you just now:\r\n
	- Atlantic Subscription Status: $atlantic_status\r\n";
	if ($atlantic_status == 'existing') {
	$message .= "- Atlantic Account ID: $atlantic_id\r\n\r\n";
	}
}

$message .= "
	- Email Address: $email\r\n
	- Names on MinnPost Membership: $name\r\n
	- Street: $street\r\n
	- City: $city\r\n
	- State: $state\r\n
	- Zip Code: $zip\r\n
	- Address Type: $address_type\r\n\r\n";
	if ($use_different_address == 1) {
	$message .= "- Shipping Name: $shipping_name\r\n
	- Shipping Street: $shipping_street\r\n
	- Shipping City: $shipping_city\r\n
	- Shipping State: $shipping_state\r\n
	- Shipping Zip Code: $shipping_zip\r\n
	- Shipping Address Type: $shipping_address_type";
	}

$message = wordwrap($message, 70, "\r\n");

?>
<?php

include('config.php');
if (isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
} else if (isset($_POST['id'])) {
	$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
} else {
	$id = '';
}
if ($_GET['debug'] === 'true') {
	echo 'loading user with id of ' . $id;
}

if ($id !== '') {
	$sql = "SELECT * FROM `{$table}` WHERE salesforce_id='$id'";
	if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $account = $result->fetch_assoc();
        $previously_changed = $account['address_changed'];
        $member_level = $account['member_level'];
    }
    if ($_GET['debug'] === 'true') {
    	print_r($account);
    }
}

if ($_SERVER['REQUEST_METHOD'] != 'POST' && $id !== '') { // form has not been submitted

	// load data from database
	$email = $account['email'];
	$name = $account['name'];
	$street = $account['street'];
	$city = $account['city'];
	$state = $account['state'];
	$zip = $account['zip'];

	$full_address = $street . ', ' . $city . ', ' . $state . ' ' . $zip;

	$atlantic_status = $account['atlantic_status'];
	$swag_status = $account['swag_status'];

	// we don't know anything about their atlantic status. give them a default value of new in the form
	if (!isset($account['atlantic_status'])) {
    	$atlantic_status = 'new';
    }
	if ($atlantic_status == 'existing') {
		$atlantic_id = $account['atlantic_id'];
	}

	if (in_array($member_level, $swag_levels) && $swag_status !== 'declined') { // check level here
		$show_swag = TRUE;
	}
	
	if (in_array($member_level, $atlantic_levels) && $atlantic_status !== 'declined') { // check level here
		$show_atlantic = TRUE;
	}

	if ($_GET['debug'] === 'true') {
		$show_swag = TRUE;
		$show_atlantic = TRUE;
	}

	include('form.php');
	
} else { // form has been submitted
	$valid = TRUE;

	$sql = "UPDATE `{$table}` SET";

	$atlantic_status = filter_var($_POST['atlantic_status'], FILTER_SANITIZE_STRING); // allow for declined here
	$swag_status = filter_var($_POST['swag_status'], FILTER_SANITIZE_STRING); // allow for declined here

	if ( (!isset($atlantic_status) && !isset($swag_status)) || ( !in_array($member_level, $swag_levels) && !in_array($member_level, $atlantic_levels) ) ) {
		// they didn't submit anything or they don't qualify
		$valid = FALSE;
	}

	if ($atlantic_status !== 'declined') { // they've accepted the atlantic
		$sql .= " atlantic_accepted = 1";
	}

	if ($swag_status !== 'declined') { // they've accepted a swag item
		$sql .= ", swag_accepted = 1";
	}

	$sql .= ", atlantic_status = '$atlantic_status', swag_status = '$swag_status'";

	if ($atlantic_status == 'existing') {
		$atlantic_id = filter_var($_POST['atlantic_id'], FILTER_SANITIZE_STRING);
		$sql .= ", atlantic_id = '$atlantic_id'";
	} else if ($atlantic_status == 'new') {
		$sql .= ", atlantic_id = ''";
	}

	// email
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$valid = FALSE;
	}

	// name and address fields
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
	$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
	$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
	$zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);

	$full_address = $street . ', ' . $city . ', ' . $state . ' ' . $zip;

	$address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
	$sql .= ", address_type = '$address_type'";

	// did they change their address?
	if ($previously_changed == 1 || $account['email'] != $email || $account['name'] != $name || $account['street'] != $street || $account['city'] != $city || $account['state'] != $state || $account['zip'] != $zip) {
		$changed = 1;
		if ($account['email'] != $email) {
			$sql .= ", email = '$email'";		
		}
		if ($account['name'] != $name) {
			$sql .= ", name = '$name'";		
		}
		if ($account['street'] != $street) {
			$sql .= ", street = '$street'";		
		}
		if ($account['city'] != $city) {
			$sql .= ", city = '$city'";		
		}
		if ($account['state'] != $state) {
			$sql .= ", state = '$state'";		
		}
		if ($account['zip'] != $zip) {
			$sql .= ", zip = '$zip'";		
		}
	} else {
		$changed = 0;
	}
	$sql .= ", address_changed = '$changed'";

	// do they have a separate shipping address?
	$use_different_address = filter_var($_POST['use_different_address'], FILTER_SANITIZE_STRING);
	if ($use_different_address == 1) {

		$shipping_name = filter_var($_POST['shipping_name'], FILTER_SANITIZE_STRING);
		$shipping_street = filter_var($_POST['shipping_street'], FILTER_SANITIZE_STRING);
		$shipping_city = filter_var($_POST['shipping_city'], FILTER_SANITIZE_STRING);
		$shipping_state = filter_var($_POST['shipping_state'], FILTER_SANITIZE_STRING);
		$shipping_zip = filter_var($_POST['shipping_zip'], FILTER_SANITIZE_STRING);

		$shipping_full_address = $shipping_street . ', ' . $shipping_city . ', ' . $shipping_state . ' ' . $shipping_zip;

		$shipping_address_type = filter_var($_POST['shipping_address_type'], FILTER_SANITIZE_STRING);

		if (isset($shipping_name)) {
			$sql .= ", shipping_name = '$shipping_name'";		
		}
		if (isset($shipping_name)) {
			$sql .= ", shipping_street = '$shipping_street'";		
		}
		if (isset($shipping_name)) {
			$sql .= ", shipping_city = '$shipping_city'";		
		}
		if (isset($shipping_name)) {
			$sql .= ", shipping_state = '$shipping_state'";		
		}
		if (isset($shipping_name)) {
			$sql .= ", shipping_zip = '$shipping_zip'";		
		}
		if (isset($shipping_address_type)) {
			$sql .= ", shipping_address_type = '$shipping_address_type'";
		}
	}

	// update the record for their salesforce id
	$sql .= " WHERE salesforce_id = '$id'";

	// only do any of this if the form is valid
	if ( isset($email) && $valid == TRUE) {
		include('config.php');
		//echo $sql;
		if(!$result = $db->query($sql)){
			die('There was an error running the query [' . $db->error . ']');
		} // was successful

		include('message.php');
		include('email.php');
		$headers = 'From: members@minnpost.com' . "\r\n" .
    'Reply-To: members@minnpost.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
		$mail = mail($email, 'MinnPost Thank You Gift Confirmation', $message, $headers);
		echo 'mail result is ' . $mail;
	} else {
		include('form.php');
	}
}

?>
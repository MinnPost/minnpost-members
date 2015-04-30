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
	echo $id;
}

if ($id !== '') {
	$sql = "SELECT * FROM `{$table}` WHERE salesforce_id='$id'";
	if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $account = $result->fetch_assoc();
        $previously_changed = $account['address_changed'];
    }
    if ($_GET['debug'] === 'true') {
    	print_r($account);
    }
}

if ($_SERVER['REQUEST_METHOD'] != 'POST' && $id !== '') {

	$email = $account['email'];
	$name = $account['name'];
	$street = $account['street'];
	$city = $account['city'];
	$state = $account['state'];
	$zip = $account['zip'];

	$full_address = $street . ', ' . $city . ', ' . $state . ' ' . $zip;

	$atlantic_status = $account['atlantic_status'];
	if (!isset($account['atlantic_status'])) {
    	$atlantic_status = 'new';
    }
	if ($atlantic_status == 'existing') {
		$atlantic_id = $account['atlantic_id'];
	}

	include('form.php');
} else {
	$valid = TRUE;

	$sql = "UPDATE `{$table}` SET accepted = 1";
	
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$valid = FALSE;
	}

	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
	$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
	$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
	$zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);

	$full_address = $street . ', ' . $city . ', ' . $state . ' ' . $zip;

	$address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
	$sql .= ", address_type = '$address_type'";

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

	$atlantic_status = filter_var($_POST['atlantic_status'], FILTER_SANITIZE_STRING);
	if (!isset($atlantic_status)) {
		$valid = FALSE;
	}
	$sql .= ", atlantic_status = '$atlantic_status'";

	if ($atlantic_status == 'existing') {
		$atlantic_id = filter_var($_POST['atlantic_id'], FILTER_SANITIZE_STRING);
		$sql .= ", atlantic_id = '$atlantic_id'";
	} else if ($atlantic_status == 'new') {
		$sql .= ", atlantic_id = ''";
	}

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

	$sql .= " WHERE salesforce_id = '$id'";

	if ( isset($email) && $valid == TRUE) {
		include('config.php');
		//echo $sql;
		if(!$result = $db->query($sql)){
			die('There was an error running the query [' . $db->error . ']');
		} else {
			// was successful
		}

		include('message.php');
	} else {
		include('form.php');
	}
}

?>
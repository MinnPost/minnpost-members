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
	$sql = "SELECT * FROM `{$table}` WHERE account_id='$id'";
	if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $account = $result->fetch_assoc();
    }
    if ($_GET['debug'] === 'true') {
    	print_r($account);
    }
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

	$email = $account['email'];
	$name = $account['name'];
	$street = $account['street'];
	$city = $account['city'];
	$state = $account['state'];
	$zip = $account['zip'];

	include('form.php');
} else {
	$valid = TRUE;
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$valid = FALSE;
	}

	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
	$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
	$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
	$zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);

	$address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);

	$shipping_name = filter_var($_POST['shipping_name'], FILTER_SANITIZE_STRING);
	$shipping_street = filter_var($_POST['shipping_street'], FILTER_SANITIZE_STRING);
	$shipping_city = filter_var($_POST['shipping_city'], FILTER_SANITIZE_STRING);
	$shipping_state = filter_var($_POST['shipping_state'], FILTER_SANITIZE_STRING);
	$shipping_zip = filter_var($_POST['shipping_zip'], FILTER_SANITIZE_STRING);

	if ($account['name'] != $name || $account['street'] != $street || $account['city'] != $city || $account['state'] != $state || $account['zip'] != $zip) {
		$changed = TRUE;
	} else {
		$changed = FALSE;
	}

	if ( isset($email) && isset($amount) && $valid == TRUE) {
		include('config.php');
		$sql = "INSERT INTO `{$table}` (email, amount, created) VALUES ('$email', '$amount', NOW() )";

		if(!$result = $db->query($sql)){
			die('There was an error running the query [' . $db->error . ']');
		} else {
			$amount = number_format($amount, 2);
		}

		include('message.php');
	} else {
		include('form.php');
	}
}

?>
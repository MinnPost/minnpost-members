<?php

include('config.php');
if (isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
} else if (isset($_POST['id'])) {
	$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
} else {
	$id = '';
}
if (isset($_GET['debug']) && $_GET['debug'] === 'true') {
	echo 'loading user with id of ' . $id;
}

if ($id !== '') {
	$sql = "SELECT * FROM `partner_offer_contacts` WHERE contact_id='$id'";
	if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $account = $result->fetch_assoc();
    }
    if (isset($_GET['debug']) && $_GET['debug'] === 'true') {
    	print_r($account);
    }
    $member = TRUE;
} else {
	$member = FALSE;
}

include('eligibility.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$account_id = $account['account_id'];
	$email = $account['email'];
	$first_name = $account['first_name'];
	$last_name = $account['last_name'];

	if (isset($_GET['debug']) && $_GET['debug'] === 'true') {
		echo 'eligible? ' . (int)$eligible;
	}

	$sql = "SELECT offers.id as offer_id, offers.event, offers.quantity, offers.item_type, offers.image_url as offer_image_url, offers.restriction, offers.more_info_text, 
	count(offer_instances.id) as instance_count, offers.more_info_url, offers.offer_start_date, offers.offer_end_date, partners.name, partners.url, partners.image_url as partner_image_url,
	offer_instances.id as instance_id, offer_instances.event_use_start, offer_instances.event_use_end, offer_instances.date_display, offer_instances.claimed
	FROM offers
	INNER JOIN offer_instances on offers.id = offer_instances.offer_id
	INNER JOIN partners on offers.partner_id = partners.id
	WHERE offers.display_start_date < now() AND offers.display_end_date > now()

	GROUP BY offer_instances.offer_id
	ORDER BY offer_instances.claimed ASC, offers.display_start_date DESC, offers.offer_start_date DESC";

	if (!$result = $db->query($sql)) {
	    die('There was an error running the query [' . $db->error . ']');
	} else {
	    include('all-offers.php');

	}

} else {
	$valid = TRUE;
	$instance_id = filter_var($_POST['instance_id'], FILTER_SANITIZE_STRING);
	$contact_id = filter_var($_POST['contact_id'], FILTER_SANITIZE_STRING);
	$claimed = date('Y-m-d H:i:s');

	if (!isset($contact_id) || !isset($instance_id)) {
		$valid = FALSE;
	}

	if ($valid === TRUE) {
		$select_sql = "SELECT claimed FROM `offer_instances` WHERE id='$instance_id'";
		if (!$select = $db->query($select_sql)) {
			die('There was an error running the query [' . $db->error . ']');
		} else {
			$check = $select->fetch_assoc();
			if ($check['claimed'] == NULL) {
				$sql = "UPDATE `offer_instances` SET contact_id = '$contact_id', claimed='$claimed' WHERE id='$instance_id'";
			} else {
				$sql = '';
				$success = FALSE;
				$contactsql = "SELECT contact_id FROM `partner_offer_contacts` WHERE id='$contact_id'";
				if (!$contactselect = $db->query($contactsql)) {
					die('There was an error running the query [' . $db->error . ']');
				} else {
					$contact = $contactselect->fetch_assoc();
					$salesforce_id = $contact['contact_id'];
				}
				include('message.php');
			}
		}

		if ( isset($claimed) && $sql !== '') {
			include('config.php');
			//echo $sql;
			if (!$result = $db->query($sql)){
				die('There was an error running the query [' . $db->error . ']');
			} else {
				// was successful
				$claimed_sql = "SELECT offers.id as offer_id, offers.event, offers.quantity, offers.item_type, offers.image_url as offer_image_url, offers.restriction, offers.more_info_text, 
				count(offer_instances.id) as instance_count, offers.more_info_url, offers.offer_start_date, offers.offer_end_date, partners.name, partners.url, partners.image_url as partner_image_url,
				offer_instances.id as instance_id, offer_instances.event_use_start, offer_instances.event_use_end, offer_instances.date_display, offer_instances.claimed
				FROM offer_instances
				INNER JOIN offers on offer_instances.offer_id = offers.id
				INNER JOIN partners on offers.partner_id = partners.id
				WHERE offer_instances.id='$instance_id'";
				if (!$claimed_result = $db->query($claimed_sql)){
					die('There was an error running the query [' . $db->error . ']');
				} else {
					$success = TRUE;
					$claimed = $claimed_result->fetch_assoc();
					include('message.php');
				}
			}
		} else if ($sql !== '') {
			include('all-offers.php');
		}
	} else {
		include('all-offers.php');
	}
}

?>
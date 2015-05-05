<?php

// check to see if user is eligible to claim anything
$local_id = $account['id'];
$user_claim_limit = "SELECT * FROM offer_instances WHERE contact_id='$local_id' AND claimed BETWEEN DATE_SUB(NOW(), INTERVAL $eligibility_period_mysql) AND NOW() ORDER BY claimed DESC";
$claim_result = $db->query($user_claim_limit);
$user_ineligible = $claim_result->num_rows;
$claim = $claim_result->fetch_assoc();
$last_partner_claim = $claimp['claimed'];

if ($user_ineligible === 1) {
	$next_partner_claim = date('Y-m-d H:i:s', strtotime("$last_partner_claim +$eligibility_period_php"));
	$eligible = FALSE;
} else {
	$eligible = TRUE;
}
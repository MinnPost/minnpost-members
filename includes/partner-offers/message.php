<section>
	<h3 class="component-label">Thank you for supporting MinnPost</h3>
<?php if ($success == TRUE) { ?>
	<p>You have claimed your offer! You will receive an email from MinnPost membership coordinator Ashleigh Swenson later today with more details. Thank you for your support of MinnPost!</p>
	<?php print_r($message); ?>
<?php } else { ?>
	<p>Sorry, this offer was already claimed. You might still be able to claim <a href="/partner-offers.php?id=<?php echo $salesforce_id; ?>">another offer</a>; otherwise try again next month!</p>
<?php } ?>
</section>
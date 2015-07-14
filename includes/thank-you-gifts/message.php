<section>
	<h3 class="component-label">Thank you for supporting MinnPost</h3>

	<?php if ($swag_status !== 'declined') { ?>
	<p>We will send your MinnPost <?php echo $swag_status; ?> to you as soon as possible.</p>
	<?php } ?>

	<?php if ($atlantic_status !== 'declined') { ?>
	<p>We will submit a subscription request to The Atlantic on your behalf. That request will include the following information, which we received from you just now:</p>
	<ul>
		<li><strong>Atlantic Subscription Status</strong>: <?php echo $atlantic_status; ?></li>
		<?php if ($atlantic_status == 'existing') { ?>
		<li><strong>Atlantic Account ID</strong>: <?php echo $atlantic_id; ?></li>
		<?php } ?>
	</ul>
	<?php } ?>

	<ul>
		<li><strong>Email Address</strong>: <?php echo $email; ?></li>
		<li><strong>Names on MinnPost Membership</strong>: <?php echo $name; ?></li>
		<li><strong>Street</strong>: <?php echo $street; ?></li>
		<li><strong>City</strong>: <?php echo $city; ?></li>
		<li><strong>State</strong>: <?php echo $state; ?></li>
		<li><strong>Zip Code</strong>: <?php echo $zip; ?></li>
		<li><strong>Address Type</strong>: <?php echo $address_type; ?></li>
		<?php if ($use_different_address == 1) { ?>
		<li><strong>Shipping Name</strong>: <?php echo $shipping_name; ?></li>
		<li><strong>Shipping Street</strong>: <?php echo $shipping_street; ?></li>
		<li><strong>Shipping City</strong>: <?php echo $shipping_city; ?></li>
		<li><strong>Shipping State</strong>: <?php echo $shipping_state; ?></li>
		<li><strong>Shipping Zip Code</strong>: <?php echo $shipping_zip; ?></li>
		<li><strong>Shipping Address Type</strong>: <?php echo $shipping_address_type; ?></li>
		<?php } ?>
	</ul>
</section>
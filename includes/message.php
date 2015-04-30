<section>
	<h3 class="component-label">Thank you for your Atlantic subscription request</h3>
	<p>We have received your subscription request, and will provide The Atlantic with the following information.</p>
	<ul>
		<li><strong>Subscription Status</strong>: <?php echo $atlantic_status; ?></li>
		<?php if ($atlantic_status == 'existing') { ?>
		<li><strong>Atlantic Account ID</strong>: <?php echo $atlantic_id; ?></li>
		<?php } ?>
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
<h1>Thank you gifts</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" value="<?php echo $account['salesforce_id']; ?>" name="id" id="id">

    <?php if ($show_swag === TRUE) { ?>
    <p class="large">As a MinnPost member, you are entitled to a MinnPost mug or water bottle<?php if ($show_atlantic === TRUE) { ?> AND a one-year subscription to the Atlantic<?php } ?>. Use this form to make your choices.</p>
    <?php } else { ?>
    <p class="large">MinnPost members at Silver level or above are entitled to a MinnPost mug or water bottle, and those at Gold or above are entitled to a one-year subscription to the Atlantic. <a href="https://www.minnpost.com/support/member-benefits">Learn more about this</a>.</p>
    <?php } ?>
    
    <?php if ($show_swag === TRUE) { ?>
    <fieldset class="benefit-option swag-type">
        <label>
            <input type="radio" name="swag_status" id="swag_mug" value="new" <?php if ($swag_status == 'mug') { ?> checked="checked"<?php } ?>>
            <div>
                <img src="//members.minnpost.com/givalike/images/mug.png" alt="Coffee Mug">
            </div>
        </label>
        <label>
            <input type="radio" name="swag_status" id="swag_bottle" value="new" <?php if ($swag_status == 'bottle') { ?> checked="checked"<?php } ?>>
            <div>
                <img src="//members.minnpost.com/givalike/images/waterbottle.png" alt="Water Bottle">
            </div>
        </label>
        <label>
            <input type="radio" name="swag_status" id="swag_declined" value="declined" <?php if ($swag_status === 'declined') { ?> checked="checked"<?php } ?>>
            <div>Decline these items</div>
        </label>
    </fieldset>
    <?php } ?>

    <?php if ($show_atlantic === TRUE) { ?>
    <fieldset class="benefit-option subscription-type">
        <p>Also, <strong>MinnPost Gold and Platinum</strong> members are entitled to a 1-year subscription to The Atlantic. This offer is available each year that you qualify.</p>
        <label><input type="radio" name="atlantic_status" id="atlantic_new" value="new" <?php if ($atlantic_status == 'new') { ?> checked="checked"<?php } ?>> Start a new subscription</label>
        <label><input type="radio" name="atlantic_status" id="atlantic_existing" value="existing" <?php if ($atlantic_status === 'existing') { ?> checked="checked"<?php } ?>> Extend an existing subscription</label>
        <div class="form-item atlantic_id">
            <label>Existing Subscription ID
              <input type="text" autocapitalize="off" autocorrect="off" name="atlantic_id" id="atlantic_id" value="<?php echo $atlantic_id; ?>">
            </label>
        </div>
        <label><input type="radio" name="atlantic_status" id="atlantic_declined" value="declined" <?php if ($atlantic_status === 'declined') { ?> checked="checked"<?php } ?>> Decline this item</label>
    </fieldset>
    <?php } ?>

    <fieldset class="form-section account-info" data-geo="data-geo">
        <h3 class="component-label">Please Verify Your MinnPost Membership Information</h3>
        <div class="form-item">
            <label>Email Address
              <input type="email" autocapitalize="off" autocorrect="off" name="email" id="email" value="<?php echo $email; ?>" required="required">
            </label>
        </div>

        <div class="form-item">
            <label>Names on MinnPost Membership
              <input type="text" autocapitalize="off" autocorrect="off" value="<?php echo $name; ?>" name="name" id="name" required="required">
            </label>
        </div>
        
        <div class="form-item not-geocomplete">
            <label>Street
              <input type="text" autocapitalize="off" autocorrect="off" name="street" id="street" value="<?php echo $street; ?>" required="required" data-geo="name">
            </label>
        </div>

        <div class="form-item not-geocomplete">
            <label>City
              <input type="text" value="<?php echo $city; ?>" name="city" id="city" required="required" data-geo="locality">
            </label>
        </div>

        <div class="form-item not-geocomplete">
            <label>State
              <input type="text" value="<?php echo $state; ?>" name="state" id="state" required="required" data-geo="administrative_area_level_1">
            </label>
        </div>

        <div class="form-item not-geocomplete">
            <label>Zip Code
              <input type="text" value="<?php echo $zip; ?>" name="zip" id="zip" required="required" data-geo="postal_code">
            </label>
        </div>

        <div class="form-item">
            <label for="address_type">Address Type</label>
            <select id="address_type" name="address_type" required="required">
                <option value="Home">Home</option>
                <option value="Work">Work</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-item">
            <label>
                <input type="checkbox" value="1" name="use_different_address" id="use_different_address"> Use a different name/address for your gifts
            </label>
        </div>

    </fieldset>

    <fieldset class="form-section shipping_address" data-geo="data-shipping-geo">
        <h3 class="component-label">Send gifts to</h3>
        <div class="form-item">
            <label>Name
              <input type="text" autocapitalize="off" autocorrect="off" value="<?php echo $shipping_name; ?>" name="shipping_name" id="shipping_name">
            </label>
        </div>
        <div class="form-item not-geocomplete">
            <label>Street
              <input type="text" autocapitalize="off" autocorrect="off" name="shipping_street" id="shipping_street" value="<?php echo $shipping_street; ?>" data-shipping-geo="name">
            </label>
        </div>

        <div class="form-item not-geocomplete">
            <label>City
              <input type="text" value="<?php echo $shipping_city; ?>" name="shipping_city" id="shipping_city" data-shipping-geo="locality">
            </label>
        </div>

        <div class="form-item not-geocomplete">
            <label>State
              <input type="text" value="<?php echo $shipping_state; ?>" name="shipping_state" id="shipping_state" data-shipping-geo="administrative_area_level_1">
            </label>
        </div>

        <div class="form-item not-geocomplete">
            <label>Zip Code
              <input type="text" value="<?php echo $shipping_zip; ?>" name="shipping_zip" id="shipping_zip" data-shipping-geo="postal_code">
            </label>
        </div>

        <div class="form-item">
            <label for="shipping_address_type">Address Type</label>
            <select id="shipping_address_type" name="shipping_address_type">
                <option value="Home">Home</option>
                <option value="Work">Work</option>
                <option value="Other">Other</option>
            </select>
        </div>

    </fieldset>

    <button class="button primary" type="submit">Submit your choices</button>

</form>
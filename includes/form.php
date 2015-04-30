<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <p class="large">You are entitled to a 1-year subscription to The Atlantic as a MinnPost Member. Submit this form to receive it.</p>
    <input type="hidden" value="1" name="accept" id="accept">
    <input type="hidden" value="<?php echo $account['account_id']; ?>" name="id" id="id">
    <section class="subscription-type">
        <label><input type="radio" name="atlantic_status" value="new"> Start a new subscription</label>
        <label><input type="radio" name="atlantic_status" value="existing" id="existing-subscription"> Extend an existing subscription</label>
        <div class="form-item atlantic_id">
            <label>Existing Subscription ID
              <input type="text" autocapitalize="off" autocorrect="off" name="atlantic_id" id="atlantic_id" value="<?php echo $atlantic_id; ?>">
            </label>
        </div>
    </section>
    <section class="account-info">
        <h3 class="component-label">Verify Your Account Information</h3>
        <div class="form-item">
            <label>Email address
              <input type="email" autocapitalize="off" autocorrect="off" name="email" id="email" value="<?php echo $email; ?>" required="required">
            </label>
        </div>

        <div class="form-item">
            <label>Account Holders
              <input type="text" autocapitalize="off" autocorrect="off" value="<?php echo $name; ?>" name="name" id="name" required="required">
            </label>
        </div>

        <div class="form-item">
            <label>Street
              <input type="text" autocapitalize="off" autocorrect="off" name="street" id="street" value="<?php echo $street; ?>" required="required">
            </label>
        </div>

        <div class="form-item">
            <label>City
              <input type="text" value="<?php echo $city; ?>" name="city" id="city" required="required">
            </label>
        </div>

        <div class="form-item">
            <label>State
              <input type="text" value="<?php echo $state; ?>" name="state" id="state" required="required">
            </label>
        </div>

        <div class="form-item">
            <label>Zip Code
              <input type="number" value="<?php echo $zip; ?>" name="zip" id="zip" required="required">
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
                <input type="checkbox" value="1" name="use-account-address" id="use-account-address"> Use a different name/address for your subscription
            </label>
        </div>

    </section>

    <section class="shipping_address">
        <h3 class="component-label">Shipping Address</h3>
        <div class="form-item">
            <label>Name
              <input type="text" autocapitalize="off" autocorrect="off" value="<?php echo $shipping_name; ?>" name="shipping_name" id="shipping_name" required="required">
            </label>
        </div>
        <div class="form-item">
            <label>Street
              <input type="text" autocapitalize="off" autocorrect="off" name="shipping_street" id="shipping_street" value="<?php echo $shipping_street; ?>">
            </label>
        </div>

        <div class="form-item">
            <label>City
              <input type="text" value="<?php echo $shipping_city; ?>" name="shipping_city" id="shipping_city">
            </label>
        </div>

        <div class="form-item">
            <label>State
              <input type="text" value="<?php echo $shipping_state; ?>" name="shipping_state" id="shipping_state">
            </label>
        </div>

        <div class="form-item">
            <label>Zip Code
              <input type="number" value="<?php echo $shipping_zip; ?>" name="shipping_zip" id="shipping_zip">
            </label>
        </div>

        <div class="form-item">
            <label for="shipping_address_type">Address Type</label>
            <select id="shipping_address_type" name="shipping_address_type" required="required">
                <option value="Home">Home</option>
                <option value="Work">Work</option>
                <option value="Other">Other</option>
            </select>
        </div>

    </section>

    <button class="button primary" type="submit">Send Your Information</button>

</form>
<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("includes/cartSession.incl.php"); ?>
<?php include("includes/errorMessage.incl.php"); ?>
<?php include("includes/definedFunctions.incl.php");?>
<?php if (isset($_POST['register'])) {
	
	$validateError  = 0;
	
	$customerFirstName = clean($_POST['firstName']);
	$customerLastName = clean($_POST['lastName']);
	$customerEmail = clean($_POST['Email']);
	$customerConfirmEmail = clean($_POST['confirmEmail']);
	$customerPassword = clean($_POST['password']);
	$customerConfirmPassword = clean($_POST['confirmPassword']);
	$customerAddress1 = clean($_POST['addressLine1']);
	$customerAddress2 = clean($_POST['addressLine2']);
	$customerCity = clean($_POST['city']);
	$customerCounty = clean($_POST['county']);
	$customerPostCode = clean($_POST['postcode']);
	$customerPhone = clean($_POST['phone']);
	
	//customerFirstName
	if (strlen($customerFirstName) == 0 ) {
		$validateError ++;
		$customerFirstNamePresent = 'False';
	}
	else
	{
		$customerFirstNamePresent = 'True';
	};
	//customerLastName
	if (strlen($customerLastName) == 0 ) {
		$validateError ++;
		$customerLastNamePresent = 'False';
	}
	else
	{
		$customerLastNamePresent = 'True';
	};
	
	//customerEmail
	if (strlen($customerEmail) == 0 ) {
		$validateError ++;
		$customerEmailPresent = 'False';
	}
	else
	{
		$customerEmailPresent = 'True';
		
		if($customerEmail != NULL){		
			/* splits the string variable in the second argument 
			 * based on the regular expression given in the first argument.
			 * The list() function assigns the result of the left hand string from the split()
			 * function to the value of the first variable name, 
			 * and the result of the right hand string from the split() function 
			 * to the value of the second variable name 
			 */
			list($userName, $mailDomain) = preg_split("/@/", $customerEmail);
						
			/* goes out on the Internet and queries the DNS server to find 
			 * whether there is a mail exchange registered for that domain 
			 * – this is the attribute MX in the second argument of the function.
			 */
			if (checkdnsrr($mailDomain, "MX")) {
				$emailValid = 'True';
			} else {
				$validateError ++;
				$emailValid = 'False';
			}
		}
		else {
			echo $customerEmail;
			$customerEmailPresent = 'False';
		};
	};
	
	//customerConfirmEmail
	if ($customerEmail !== $customerConfirmEmail) {
		$validateError ++;
		$emailMatch = 'False';
	}
	else
	{
		$emailMatch = 'True';
	};

	//customerPassword
	if (strlen($customerPassword) == 0) {
		$validateError ++;
		$customerPasswordPresent = 'False';
	}
	else
	{
		$customerPasswordPresent = 'True';
	};
	
	if (strlen($customerPassword) < 8 ) {
		$validateError ++;
		$passwordLength = 'False';
	}
	else
	{
		$passwordLength = 'True';
	};
	
		
	//customerConfirmPassword
	if ($customerPassword !== $customerConfirmPassword) {
		$validateError ++;
		$passwordMatch = 'False';
	}
	else
	{
		$passwordMatch = 'True';
	};
	
	//customerAddress1
	if (strlen($customerAddress1) == 0 ) {
		$validateError ++;
		$customerAddress1Present = 'False';
	}
	else
	{
		$customerAddress1Present = 'True';
	};
	
	//customerCity
	if (strlen($customerCity) == 0 ) {
		$validateError ++;
		$customerCityPresent = 'False';
	}
	else
	{
		$customerCityPresent = 'True';
	};
	
	//customerCounty
	if (($customerCounty) == 'Select a County') {
		$validateError ++;
		$customerCountyPresent = 'False';
	}
	else
	{
		$customerCountyPresent = 'True';
	};
	
	//customerPostCode
	if (strlen($customerPostCode) == 0 ) {
		$validateError ++;
		$customerPostCodePresent = 'False';
	}
	else
	{
		$customerPostCodePresent = 'True';
	};
	
	//customerPhone
	if (strlen($customerPhone) == 0 ) {
		$validateError ++;
		$customerPhonePresent = 'False';
	}
	else
	{
		$customerPhonePresent = 'True';
	};
}
?>
<?php
	if (isset($_POST['register']) && ($validateError == 0)) {
	
		$customerUserName = strtolower($customerFirstName.'.'.$customerLastName);
		
		// define a salt to strengthen encryption
		define('SALT','sodium');
		
		$customerPassword = md5(SALT.$customerPassword);
		
		// add new user to the database
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
		
		$insertSQL = "INSERT INTO customers SET
						customerUserName = '$customerUserName',
						customerFirstName = '$customerFirstName',
						customerLastName = '$customerLastName',
						customerEmail = '$customerEmail',
						customerPassword = '$customerPassword',
						customerAddress1 = '$customerAddress1',
						customerAddress2 = '$customerAddress2',
						customerCity = '$customerCity',
						customerCounty = '$customerCounty',
						customerPostCode = '$customerPostCode',
						customerPhone = '$customerPhone'";
		
		$result = mysql_query($insertSQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		// if user added to database pass over to delivery input
		if ($result) {
			// set session variables to transmit customer details for delivery
			$_SESSION['customerFirstName'] = $customerFirstName;
			$_SESSION['customerLastName'] = $customerLastName;
			$_SESSION['customerPhone'] = $customerPhone;
			$_SESSION['customerAddress1'] = $customerAddress1;
			$_SESSION['customerAddress2'] = $customerAddress2;
			$_SESSION['customerCity'] = $customerCity;
			$_SESSION['customerCounty'] = $customerCounty;
			$_SESSION['customerPostCode'] = $customerPostCode;
			
			/* executes a query of the database 
			 * which returns the id number of the last entry. 
			 * The value is then passed to the customerID session variable.
			 */
			$_SESSION['customerID'] = mysql_insert_id();
			
			header("Location:delivery.php");
		}
	}
?>
<?php include("includes/headerCheckout.incl.php") ?>
    <article id="fullsize">
      <div class="heading">
        <h1>Sign In (not yet implemented function)</h1>
      </div>
      <div class="content">
      <div id="loginForm">
        <form action="" method="post" id="loginForm">
          <div>
            <label for="Email" style="width: 80px;padding: 0px;">Email: <span class="reqd">*</span></label>
            <input type="text" name="sEmail" style="width: 200px;">
            </input>
          </div>
          <div>
            <label for="password" style="width: 80px;padding: 0px;"> Password: <span class="reqd">*</span></label>
            <input type="password" name="sPassword" style="width: 200px;">
            </input>
            <p id="explain" style="width: 200px; float: left; text-align: center;"> <a href="forgot.php">Forgot password?</a></p>
            <div style="width: 100px; float: left; display: inline;">
              <input class="button" type="submit" value="Sign Me In »" name="sign-in" style="width: 100px; float: right;">
              </input>
            </div>
          </div>
        </form>
      </div>
      </div>
      <div class="heading">
        <h1> or Register for your Recipesjack Account</h1>
        <p class="inset">Details should be as registered for the credit card to be used with this account.</p>
      </div>
      <div class="content">
        <div>
          <?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>
          <form action="" method="post">
            <div id="leftBlock">
              <h2>Your personal details</h2>
              <label for="firstName">First Name:<span class="reqd">*</span> </label>
              <input name="firstName" type="text">
              <br>
              <br>
              <label for="lastName">Last Name:<span class="reqd">*</span> </label>
              <input name="lastName" type="text">
              <br>
              <br>
              <h2>Your login details</h2>
              <label for="Email">Email:<span class="reqd">*</span> </label>
              <input name="Email" type="text">
              <br>
              <br>
              <label for="confirmEmail">Confirm Email:<span class="reqd">*</span> </label>
              <input name="confirmEmail" type="text">
              <br>
              <br>
              <label for="password">Password:<span class="reqd">*</span> </label>
              <input name="password" type="password">
              <br>
              <br>
              <label for="confirmPassword">Confirm Password:<span class="reqd">*</span> </label>
              <input name="confirmPassword" type="password">
              <br>
              <br>
            </div>
            <div id="rightBlock">
              <h2>Your contact details</h2>
              <label for="addressLine1">Address line 1:<span class="reqd">*</span> </label>
              <input name="addressLine1" type="text">
              <br>
              <br>
              <label for="addressLine2">Address line 2:&nbsp; </label>
              <input name="addressLine2" type="text">
              <br>
              <br>
              <label for="city">Town/City:<span class="reqd">*</span> </label>
              <input name="city" type="text">
              <br>
              <br>
              <label for="county">County:<span class="reqd">*</span> </label>
              <select name="county">
                <option selected="selected">Select a County</option>
                <?php include("includes/counties.incl.php") ?>
              </select>
              <br>
              <br>
              <label for="postcode">Postcode:<span class="reqd">*</span> </label>
              <input name="postcode" type="text">
              <br>
              <br>
              <h2>Please enter a contact telephone number</h2>
              <label for="phone">Telephone:<span class="reqd">*</span> </label>
              <input name="phone" type="text">
              <br>
              <br>
              <div id="regButnBox">
                <input name="register" class="button" type="submit" value="Register now &raquo;">
              </div>
            </div>
          </form>
          <?php } else { ?>
          <form action="" method="post">
            <div id="leftBlock">
              <h2>Your personal details</h2>
              <label for="firstName">First Name:<span class="reqd">*</span> </label>
              <input name="firstName" type="text" value="<?php echo display($customerFirstName) ?>">
              <br>
              <br>
              <label for="lastName">Last Name:<span class="reqd">*</span> </label>
              <input name="lastName" type="text" value="<?php echo display($customerLastName) ?>">
              <br>
              <br>
              <h2>Your login details</h2>
              <label for="Email">Email:<span class="reqd">*</span> </label>
              <input name="Email" type="text" value="<?php echo display($customerEmail) ?>">
              <br>
              <br>
              <label for="confirmEmail">Confirm Email:<span class="reqd">*</span> </label>
              <input name="confirmEmail" type="text">
              <br>
              <br>
              <label for="password">Password:<span class="reqd">*</span> </label>
              <input name="password" type="password">
              <br>
              <br>
              <label for="confirmPassword">Confirm Password:<span class="reqd">*</span> </label>
              <input name="confirmPassword" type="password">
              <br>
              <br>
            </div>
            <div id="rightBlock">
              <h2>Your contact details</h2>
              <label for="addressLine1">Address line 1:<span class="reqd">*</span> </label>
              <input name="addressLine1" type="text" value="<?php echo display($customerAddress1) ?>">
              <br>
              <br>
              <label for="addressLine2">Address line 2:&nbsp; </label>
              <input name="addressLine2" type="text" value="<?php echo display($customerAddress2) ?>">
              <br>
              <br>
              <label for="city">Town/City:<span class="reqd">*</span> </label>
              <input name="city" type="text" value="<?php echo display($customerCity) ?>">
              <br>
              <br>
              <label for="county">County:<span class="reqd">*</span> </label>
              <select name="county">
                <option selected="selected" value="<?php echo display($customerCounty);?>"> <?php echo display($customerCounty); ?></option>
                <?php include("includes/counties.incl.php") ?>
              </select>
              <br>
              <br>
              <label for="postcode">Postcode:<span class="reqd">*</span> </label>
              <input name="postcode" type="text" value="<?php echo display($customerPostCode) ?>">
              <br>
              <br>
              <h2>Please enter a contact telephone number</h2>
              <label for="phone">Telephone:<span class="reqd">*</span> </label>
              <input name="phone" type="text" value="<?php echo display($customerPhone) ?>">
              <br>
              <br>
              <div id="regButnBox">
                <input name="register" class="button" type="submit" value="Register now &raquo;">
              </div>
            </div>
          </form>
          <?php } ?>
          <div class="reqdFields"><span class="reqd">*</span> required fields</div>
          <div class="errorMessages" id="errorLeft">
            <?php
	if ($customerFirstNamePresent == 'False')
		{echo "Please input your first name<br>\n";}
	if ($customerLastNamePresent == 'False')
		{echo "Please input your last name<br>\n";}
	if ($customerEmailPresent == 'False')
		{echo "Please input a valid email address<br>\n";}
	if ($emailMatch == 'False')
		{echo "The email addresses you entered do not match, please try again<br>\n";}
	if ($emailValid == 'False' && $customerEmailPresent == 'True')
		{echo "Please input a valid email address<br>\n";}
	if ($customerPasswordPresent == 'False')
		{echo "Please input a password<br>\n";}
	if ($passwordMatch == 'False')
		{echo "The passwords you entered do not match, please try again<br>\n";}
	if ($passwordLength == 'False' && $customerPasswordPresent == 'True')
		{echo "Please enter a password of at least 8 characters<br>\n";}
	?>
          </div>
          <div class="errorMessages" id="errorRight">
            <?php 
     if($customerAddress1Present == 'False')
	 	{echo "Please input the first line of your address<br>\n";}
	 if($customerCityPresent == 'False')
	 	{echo "Please input the Town or City<br>\n";}
	 if($customerCountyPresent == 'False')
	 	{echo "Please select a County<br>\n";}
	 if($customerPostCodePresent == 'False')
	 	{echo "Please input your postcode<br>\n";}
	 if($customerPhonePresent == 'False')
	 	{echo "Please input your telephone number<br>\n";}
    ?>
          </div>
        </div>
      </div>
    </article>
  </div>
  <div class="clear"></div>
</section>
<?php include("includes/simpleFooterHTML.incl.php") ?>
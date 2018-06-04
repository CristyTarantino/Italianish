<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("includes/cartSession.incl.php"); ?>
<?php include("includes/errorMessage.incl.php"); ?>
<?php include("includes/definedFunctions.incl.php");?>
<?php 	
	// collect session variables to set customer details for delivery
	if(isset($_POST['detailsDupe'])) {
		$shippingFirstName = $_SESSION['customerFirstName'];
		$shippingLastName = $_SESSION['customerLastName'];
		$shippingPhone = $_SESSION['customerPhone'];
		$shippingAddress1 = $_SESSION['customerAddress1'];
		$shippingAddress2 = $_SESSION['customerAddress2'];
		$shippingCity = $_SESSION['customerCity'];
		$shippingCounty = $_SESSION['customerCounty'];
		$shippingPostCode = $_SESSION['customerPostCode'];
	}
?>
<?php if (isset($_POST['delivery'])) {
	
	$shippingFirstName = clean($_POST['firstNameDel']);
	$shippingLastName = clean($_POST['lastNameDel']);
	$shippingPhone = clean($_POST['contactPhoneDel']);
	$shippingAddress1 = clean($_POST['addressLine1Del']);
	$shippingAddress2 = clean($_POST['addressLine2Del']);
	$shippingCity = clean($_POST['cityDel']);
	$shippingCounty = clean($_POST['countyDel']);
	$shippingPostCode = clean($_POST['postcodeDel']);
	
	//shippingFirstName
	if (strlen($shippingFirstName) == 0 ) {
		$validateError ++;
		$shippingFirstNamePresent = 'False';
	}
	else
	{
		$shippingFirstNamePresent = 'True';
	};
	//shippingLastName
	if (strlen($shippingLastName) == 0 ) {
		$validateError ++;
		$shippingLastNamePresent = 'False';
	}
	else
	{
		$shippingLastNamePresent = 'True';
	};
	
	//shippingAddress1
	if (strlen($shippingAddress1) == 0 ) {
		$validateError ++;
		$shippingAddress1Present = 'False';
	}
	else
	{
		$shippingAddress1Present = 'True';
	};
	
	//shippingCity
	if (strlen($shippingCity) == 0 ) {
		$validateError ++;
		$shippingCityPresent = 'False';
	}
	else
	{
		$shippingCityPresent = 'True';
	};
	
	//shippingCounty
	if (($shippingCounty) == 'Select a County') {
		$validateError ++;
		$shippingCountyPresent = 'False';
	}
	else
	{
		$shippingCountyPresent = 'True';
	};
	
	//shippingPostCode
	if (strlen($shippingPostCode) == 0 ) {
		$validateError ++;
		$shippingPostCodePresent = 'False';
	}
	else
	{
		$shippingPostCodePresent = 'True';
	};
	
	//shippingPhone
	if (strlen($shippingPhone) == 0 ) {
		$validateError ++;
		$shippingPhonePresent = 'False';
	}
	else
	{
		$shippingPhonePresent = 'True';
	};
}
?>
<?php
	if (isset($_POST['delivery']) && ($validateError == 0)) {
		// set variables to transmit order details
		$orderStatus = 'pending';
		$customerID = $_SESSION['customerID'];
		$shippingFirstName = clean($_POST['firstNameDel']);
		$shippingLastName = clean($_POST['lastNameDel']);
		$shippingPhone = clean($_POST['contactPhoneDel']);
		$shippingAddress1 = clean($_POST['addressLine1Del']);
		$shippingAddress2 = clean($_POST['addressLine2Del']);
		$shippingCity = clean($_POST['cityDel']);
		$shippingCounty = clean($_POST['countyDel']);
		$shippingPostCode = clean($_POST['postcodeDel']);
		
		// add order details to the database
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
		$insertSQL = "INSERT INTO orders SET
						cartSessionID = '$cartSessionID',
						orderStatus = '$orderStatus',
						customerID = '$customerID',
						shippingFirstName = '$shippingFirstName',
						shippingLastName = '$shippingLastName',
						shippingPhone = '$shippingPhone',
						shippingAddress1 = '$shippingAddress1',
						shippingAddress2 = '$shippingAddress2',
						shippingCity = '$shippingCity',
						shippingCounty = '$shippingCounty',
						shippingPostCode = '$shippingPostCode'";
		$result = mysql_query($insertSQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		if ($result) {
			header("Location:confirm.php");
		}
	}
?>
<?php include("includes/headerCheckout.incl.php") ?>
		<article id="fullsize">
			<div class="heading">
				<h1>Delivery Address</h1>
			</div>
			<div class="content">
            	<div>
				<?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>    
    <form action="" method="post">    
    <h2>Enter details of delivery address</h2>
    <p>Please enter the delivery information for the order. If the delivery details are the same as the Recipesjack Account holder please <input name="detailsDupe" class="button" id="detailsDupe" type="submit" value="click here"></p>

    <div id="leftBlock" class="first">
        <label for="firstNameDel">First Name:<span class="reqd">*</span> </label>
        <input name="firstNameDel" type="text"><br><br>
        <label for="lastNameDel">Last Name:<span class="reqd">*</span> </label>
        <input name="lastNameDel" type="text"><br><br>
        <label for="contactPhoneDel">Contact telephone:<br>(for address label)&nbsp;</label>
        <input name="contactPhoneDel" type="text"><br><br>
        <div style="margin:90px 0 0 164px; float:left;"><span class="reqd">*</span> required fields</div>
        <div style="margin:60px 0 0 164px; float:left;">
            <input name="delivery" class="button" type="submit" value="Continue &raquo;">
        </div>

    </div>

    <div id="rightBlock" class="first">
		<label for="addressLine1Del">Address line 1:<span class="reqd">*</span> </label>
        <input name="addressLine1Del" type="text"><br><br>
		<label for="addressLine2Del">Address line 2:&nbsp; </label>
        <input name="addressLine2Del" type="text"><br><br>
		<label for="cityDel">Town/City:<span class="reqd">*</span> </label>
        <input name="cityDel" type="text"><br><br>
		<label for="countyDel">County:<span class="reqd">*</span> </label>
        <select name="countyDel">
            <option selected="selected">Select a County</option>
            <?php include("includes/counties.incl.php") ?>
            </select><br><br>
        <label for="postcodeDel">Postcode:<span class="reqd">*</span> </label>
        <input name="postcodeDel" type="text"><br><br>
    </div>
    </form>
<?php } else { ?>

   <form action="" method="post">    
    <h2>Enter details of delivery address</h2>
    <p>Please enter the delivery information for the order. If the delivery details are the same as the Recipesjack Account holder please <input name="detailsDupe" class="button" id="detailsDupe" type="submit" value="click here"></p>

    <div id="leftBlock" class="first">
        <label for="firstNameDel">First Name:<span class="reqd">*</span> </label>
        <input name="firstNameDel" type="text" value="<?php echo display($shippingFirstName); ?>"><br><br>
        <label for="lastNameDel">Last Name:<span class="reqd">*</span> </label>
        <input name="lastNameDel" type="text" value="<?php echo display($shippingLastName); ?>"><br><br>
        <label for="contactPhoneDel">Contact telephone:<br>(for address label)&nbsp;</label>
        <input name="contactPhoneDel" type="text" value="<?php echo display($shippingPhone); ?>"><br><br>
        <div style="margin:90px 0 0 164px; float:left;"><span class="reqd">*</span> required fields</div>
        <div style="margin:60px 0 0 164px; float:left;">
            <input name="delivery" class="button" type="submit" value="Continue &raquo;">
        </div>

    </div>

    <div id="rightBlock" class="first">
		<label for="addressLine1Del">Address line 1:<span class="reqd">*</span> </label>
        <input name="addressLine1Del" type="text" value="<?php echo display($shippingAddress1);?>"><br><br>
		<label for="addressLine2Del">Address line 2:&nbsp; </label>
        <input name="addressLine2Del" type="text" value="<?php echo display($shippingAddress2);?>"><br><br>
		<label for="cityDel">Town/City:<span class="reqd">*</span> </label>
        <input name="cityDel" type="text" value="<?php echo display($shippingCity);?>"><br><br>
		<label for="countyDel">County:<span class="reqd">*</span> </label>
        <select name="countyDel">
            <option selected="selected" value="<?php echo display($shippingCounty);?>">
			<?php echo display($shippingCounty); ?></option>
			<?php include("includes/counties.incl.php") ?>
		</select><br><br>
        <label for="postcodeDel">Postcode:<span class="reqd">*</span> </label>
        <input name="postcodeDel" type="text" value="<?php echo display($shippingPostCode);?>"><br><br>
    </div>
    </form>
<?php } ?>

    <div style="float:left; margin:60px 0 0 173px; font-size:10px; color:#F00;">
    <?php
		if ($shippingFirstNamePresent == 'False')
			{echo "Please input your first name<br>\n";}
		if ($shippingLastNamePresent == 'False')
			{echo "Please input your last name<br>\n";}
		if($shippingAddress1Present == 'False')
			{echo "Please input the first line of your address<br>\n";}
		if($shippingCityPresent == 'False')
			{echo "Please input the Town or City<br>\n";}
		if($shippingCountyPresent == 'False')
			{echo "Please select a County<br>\n";}
		if($shippingPostCodePresent == 'False')
			{echo "Please input your postcode<br>\n";}
		if($shippingPhonePresent == 'False')
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
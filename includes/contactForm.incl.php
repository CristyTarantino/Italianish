<div id="contactForm">
<?php  if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>
			<form action="" method="post" name="contactForm">
            	<label for="name">name:</label>
                <input name="name" type="text" placeholder="name">
            	<label for="email">email:</label>
                <input name="email" type="text" placeholder="email address (required)">
            	<label for="tel">telephone:</label>
                <input name="tel" type="text" placeholder="telephone number, including country code">
            	<label for="address">address:</label>
                <input name="address" type="text" placeholder="your contact postal address">
            	<label for="enquiry">enquiry:</label>
                <textarea name="enquiry" placeholder="type your enquiry here and press the button below"></textarea>
                <input id="submit" name="submit" type="submit" value="Make contact">
            </form>

<?php  } else { ?>

<?php // Create all the variables needed to validate the form

	// Set up the error status
	$Error = 'N';
	
	// Bring in the values fdrom the submitted form
	$name		= htmlspecialchars($_POST['name']);
	$email		= htmlspecialchars($_POST['email']);
	$tel		= htmlspecialchars($_POST['tel']);
	$address	= htmlspecialchars($_POST['address']);
	$enquiry	= htmlspecialchars($_POST['enquiry']);

	// check if the email address is valid
	list($userName, $mailDomain) = split("@", $email);
	if (checkdnsrr($mailDomain, "MX")) {
	 $mlvalid = 'Y';
	}
	else {
	 $mlvalid = 'N';
	} 
?>						

			<form action="" method="post" name="contactForm">
            	<label for="name">name:</label>
                <input name="name" type="text" placeholder="name" value="<?php echo $name; ?>">
            	<label for="email">email:</label>
                <input name="email" type="text" placeholder="email address (required)" value="<?php echo $email; ?>">
            	<label for="tel">telephone:</label>
                <input name="tel" type="text" placeholder="telephone number, including country code" value="<?php echo $tel; ?>">
            	<label for="address">address:</label>
                <input name="address" type="text" placeholder="your contact postal address" value="<?php echo $address; ?>">
            	<label for="enquiry">enquiry:</label>
                <textarea name="enquiry" placeholder="type your enquiry here and press the button below"><?php echo $enquiry; ?></textarea>
                <input id="submit" name="submit" type="submit" value="Make contact">
            </form>

<?php
	// Test to see if a valid email has been supplied
	if ($email == '' or $mlvalid == 'N') {
		$Error = 'Y';
		echo "<p class=\"errorText\">Please input a valid email address so that we may contact you.</p>";
	}
?>

<?php include("includes/sendMail2Recipesjack.incl.php"); ?>
<?php include("includes/sendMail2Visitor.incl.php"); ?>

<?php }	// end of the form validation  ?>

        <!-- end of contactForm--></div>

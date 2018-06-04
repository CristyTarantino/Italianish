<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php 
	if(!isset($_SESSION)) 
	{
		session_start();
		$_SESSION['userAuthorised'] = 'False';
	}
?>
<?php if(isset($_POST['submit']))
		{			
			$firstName=addslashes(htmlentities($_POST['firstName']));
			$lastName=addslashes(htmlentities($_POST['lastName']));
			$email=addslashes(htmlentities($_POST['email']));
			$emailConf=addslashes(htmlentities($_POST['emailConf']));
			$password=addslashes(htmlentities($_POST['password']));
			$passwordConf=addslashes(htmlentities($_POST['passwordConf']));
			
			$error = 0;
			
			if(strlen($firstName) == 0 ){
				$error ++;
				$firstNamePresent = 'False';
			}
			else{
				$firstNamePresent = 'True';
			};
			
			if(strlen($lastName) == 0 ){
				$error ++;
				$lastNamePresent = 'False';
			}
			else{
				$lastNamePresent = 'True';
			};
			
			if(strlen($email) == 0 ){
				$error ++;
				$emailPresent = 'False';
			}
			else{
				$emailPresent = 'True';
				
				$tempEmail = $email;
				
				list($userName, $mailDomain) = split("@", $tempEmail);
				if(checkdnsrr($mailDomain, "MX")){
					$emailValid = 'True';
				}
				else
				{
					$error ++;
					$emailValid = 'False';
				};
			};
			
			if($email !== $emailConf){
				$error ++;
				$emailMatch = 'False';
			}
			else{
				$emailMatch = 'True';
			};
			
			if(strlen($password) == 0 ){
				$error ++;
				$passwordPresent = 'False';
			}
			else{
				$passwordPresent = 'True';
			};
			
			if(strlen($password) < 8 ){
				$error ++;
				$passwordLength = 'False';
			}
			else{
				$passwordLength = 'True';
			};
			
			if($password !== $passwordConf){
				$error ++;
				$passwordMatch = 'False';
			}
			else{
				$passwordMatch = 'True';
			};
		}
?>
<?php if(isset($_POST['submit']) && ($error == 0)){		
			define('SALT', 'M09a06R72k');
			$password = md5(SALT.$password);
			
			$query_rsUser = "INSERT INTO users SET firstName = '$firstName',
												   lastName = '$lastName',
												   email = '$email',
												   password = '$password'" ;
								
			mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
			
			$result = mysql_query($query_rsUser, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
			
			if($result){
				$_SESSION['userAuthorised'] = 'True';
				header("Location: ../dashboard/dbdIndex.php");	
			}
		} 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>New Account Registration</title>
<link rel="stylesheet" type="text/css" href="../dashboard/style/dashboard.css">
</head>

<body>
	<div id="container">
		<p class="errorText"></p>
        <?php if($_SERVER['REQUEST_METHOD']=='GET') { ?>		
        <form id="registrationForm" action="" method="post" name="registrationForm">
            <fieldset>
                <legend>Register</legend>
                <p id="explain">To get started please register for an account. Please note that your email address will be your username.</p>
                <label class="regtn" for="firstName">First Name: </label>
                    <input name="firstName" type="text" placeholder="Please enter your first name"><br><br>
                <label class="regtn" for="lastName">Last Name: </label>
                    <input name="lastName" type="text" placeholder="Please enter your last name"><br><br>
                <label class="regtn" for="email">Email: </label>
                    <input name="email" type="text" placeholder="please use your main email address"><br><br>
                <label class="regtn" for="email">Confirm Email: </label>
                    <input name="emailConf" type="text" placeholder="please re-enter you email"><br><br>
                <label class="regtn" for="password">Choose Password: </label>
                    <input name="password" type="password" placeholder="minimum of 8 characters required"><br><br>
                <label class="regtn" for="passwordConf">Confirm Password: </label>
                    <input name="passwordConf" type="password" placeholder="please re-enter the chosen password"><br><br>
                <label for="submit">&nbsp;</label>
                    <input name="submit" id="regsbmt" type="submit" class="button" value="register">
            </fieldset>
        </form>
        <?php } else { ?>
        <form id="registrationForm" action="" method="post" name="registrationForm">
            <fieldset>
                <legend>Register</legend>
                <p id="explain">To get started please register for an account. Please note that your email address will be your username.</p>
                <label class="regtn" for="firstName">First Name: </label>
                    <input name="firstName" type="text" placeholder="Please enter your first name" value="<?php echo stripslashes(html_entity_decode(stripslashes($firstName))); ?>"><br><br>
                    <?php if($firstNamePresent == 'False') echo '<p class=\"warning\">Please enter a valid name.</p><br><br>'; ?>
                <label class="regtn" for="lastName">Last Name: </label>
                    <input name="lastName" type="text" placeholder="Please enter your last name" value="<?php echo stripslashes(html_entity_decode(stripslashes($lastName))); ?>"><br><br>
                    <?php if($lastNamePresent == 'False') echo '<p class=\"warning\">Please enter a valid surname.</p><br><br>'; ?>
                <label class="regtn" for="email">Email: </label>
                    <input name="email" type="text" placeholder="please use your main email address" value="<?php stripslashes(html_entity_decode(stripslashes($email))); ?>"><br><br>
                    <?php if( $emailPresent == 'False' || $emailValid = 'False') echo '<p class=\"warning\">Please enter a valid email address.</p><br><br>'; ?>
                <label class="regtn" for="email">Confirm Email: </label>
                    <input name="emailConf" type="text" value="<?php stripslashes(html_entity_decode(stripslashes($emailConf))); ?>"><br><br>
                <?php if($emailMatch == 'False') echo '<p class=\"warning\">Your Email confirmation does not match your Email.</p><br><br>'; ?>
                <label class="regtn" for="password">Choose Password: </label>
                    <input name="password" type="password" placeholder="minimum of 8 characters required"><br><br>
                <?php if( $passwordPresent = 'False')
						echo '<p class=\"warning\">Please enter a valid password.</p><br><br>';
					  else if( $passwordPresent = 'True' && $passwordLength = 'False')
					  	echo '<p class=\"warning\">The password must be at least 8 characters long.</p><br><br>'; ?>
                <label class="regtn" for="passwordConf">Confirm Password: </label>
                    <input name="passwordConf" type="password"><br><br>
                <?php if($passwordMatch = 'False') echo '<p class=\"warning\">Your Password confirmation does not match your Password.</p><br><br>'; ?>
                <label for="submit">&nbsp;</label>
                    <input name="submit" id="regsbmt" type="submit" class="button" value="register">
            </fieldset>
        </form>
        <?php } ?>
    </div>
</body>
</html>

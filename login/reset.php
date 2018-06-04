<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php 
	if(isset($_POST['submit']))
	{
		$email = addslashes(htmlentities($_POST['username']));
		$password = addslashes(htmlentities($_POST['password']));
		$passwordConf = addslashes(htmlentities($_POST['passwordConf']));
		
		$error = 0;
		
		if(strlen($email) == 0 ){
				$error ++;
				$emailPresent = 'False';
			}
			else{
				$emailPresent = 'True';
				
				list($userName, $mailDomain) = split("@", $email);
				if(checkdnsrr($mailDomain, "MX")){
					$error ++;
					$emailValid = 'True';
				}
				else
				{
					$emailValid = 'False';
				};
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
			
			$query_rsUser = "UPDATE users SET password = '$password' WHERE email = '$email'";
								
			mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
			
			$result = mysql_query($query_rsUser, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
			
			if($result){
				$_SESSION['userAuthorised'] = 'True';
				header("Location: ../dashboard/dbIndex.php");	
			}
		} 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password</title>
<link rel="stylesheet" type="text/css" href="../dashboard/style/dashboard.css">
</head>
<body>
  <div id="container">
     <form action="" method="post" name="resetPwdForm">
        <fieldset>
            <legend>Reset Password</legend>
                <label class="regtn" for="username">User Name: </label>
                    <input name="username" type="text" placeholder="username"><br><br>
                <label class="regtn" for="password">Choose New Password: </label>
                    <input name="password" type="password" placeholder="minimum of 8 characters required"><br><br>
                <label class="regtn" for="passwordConf">Confirm New Password: </label>
                    <input name="passwordConf" type="password" placeholder="retype new password"><br><br>
                <label class="regtn" for="submit">&nbsp;</label>
                	<input name="submit" id="resetsbmt" type="submit" class="button" value="reset password">
        </fieldset>
    </form>
  </div>
</body>
</html>
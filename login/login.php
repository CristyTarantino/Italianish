<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php 
	if(!isset($_SESSION)) 
	{
		session_start();
		if($_SESSION['userAuthorised'] == 'False')
				$errorMessage = "Access to that page is restricted, please login.";
	}
?>
<?php if(isset($_POST['submit']))
		{			
			$password = addslashes(htmlentities($_POST['password']));
			$email = addslashes(htmlentities($_POST['username']));
			
			define('SALT', 'M09a06R72k');

			$password = md5(SALT.$password);
	
			mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
			
			$query_rsUser = "SELECT email, password FROM users WHERE users.email = '$email' AND users.password = '$password'";
			
			$result = mysql_query($query_rsUser, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
			
			if($result){
				$rsUser = mysql_fetch_assoc($result);
				
				if($rsUser['email'] == $email && $rsUser['password'] == $password){				
					$_SESSION['userAuthorised'] = 'True';
					header("Location: ../dashboard/dbdIndex.php");
				}
			}
		}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../dashboard/style/dashboard.css">
<title>Login</title>
</head>

<body>
	<div id="container">
    <?php if($_SESSION['userAuthorised'] == 'False')
			echo "<p class=\"warning\">" . $errorMessage . "</p>"; ?>
    <?php 
	if(isset($_GET['loggedout']))
			echo "<p class=\"warning\"> You have now been logged out. </p>"; ?>
      <form action="" method="post" id="loginForm">
        <fieldset>
          <legend>Login</legend>
          <label for="username">User Name: </label>
              <input name="username" type="text" placeholder="username"><br><br>
          <label for="password">Password: </label>
              <input name="password" type="password" placeholder="password"><br><br>
              <p id="explain"><a href="forgot.php">Forgot password?</a></p>
          <label for="submit">&nbsp;</label>
              <input name="submit" id="submit" type="submit" class="button" value="login">
        </fieldset>
      </form>
    </div>
</body>
</html>
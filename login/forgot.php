<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php
	if(isset($_POST['forgottenPwd']))
	{	
		$email = addslashes(htmlentities($_POST['username']));
		include("../includes/resetPasswordMail.incl.php");
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../dashboard/style/dashboard.css">
<title>Forgotten password</title>
</head>
<body>
	<div id="container">
  		<form action="" method="post" id="forgottenPwd">
            <fieldset>
                <legend>Forgotten password</legend>
                <label for="username">User Name: </label>
                    <input name="username" type="text" placeholder="username"><br><br>
                <p id="explain">Click on the button and an email will be sent to the addess associated with this User Name</p>
                <label for="submit">&nbsp;</label>
	                <input name="forgottenPwd" id="submit" type="submit" class="button" value="mail my password">
            </fieldset>
        </form>
    </div>
</body>
</html>

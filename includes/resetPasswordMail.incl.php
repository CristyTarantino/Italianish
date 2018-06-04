<?php
// gets mail address from main script
$to  = $email;

// subject
$subject = 'Reset password';

// message - sends HTML in order to give live URL.
$message = '
<html>
<head>
  <title>Reset password</title>
</head>
  	<p>Click <a href="http://www.mctarantino.com/projects/Recipejack/login/reset.php">here</a> to re-enter the site and reset your password.</p>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Recipesjack <noreply@recipesjack.com>' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
?>
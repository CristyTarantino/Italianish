<?php
	// check if session started if not then start session
	if (!isset($_SESSION)) {
		session_start();
	
		// check if session authorised if not then redirect to login.php
		if ($_SESSION['userAuthorised'] != 'True') {	
			$_SESSION['userAuthorised'] = 'False';
			header("location:../login/login.php");
		};
	}
?>
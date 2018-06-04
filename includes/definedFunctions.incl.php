<?php 

function clean($data) {

	//removes whitespaces and other predefined characters from both sides of a string.
    $data = trim($data);
    
    //escapes special characters in the string variable of the argument so that it is safe to place the string in a mysql_query().
    $data = mysql_real_escape_string($data);
    
    //returns a string with all HTML character entities translated to HTML entities so from (Jane &amp; 'Tarzan') => (Jane &amp; &#039;Tarzan&#039;)
    $data = htmlentities($data);
    
    return $data;
}

function display($data) {
	
	//removes backslashes added by the addslashes() or mysql_real_escape_string() functions.
    $data = stripslashes($data);
	
	// converts HTML entities to characters, opposite of htmlentities().
    $data = html_entity_decode($data);
    
	$data = stripslashes($data);
    return $data;
}

?>
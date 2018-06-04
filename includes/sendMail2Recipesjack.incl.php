<?php
// In case any of the lines are larger than 70 chars
$enquiry = wordwrap($enquiry, 70);

// send mail to enquirer
$to = 'm.cristina.tarantino@gmail.com';
$subject = 'Recipesjack enquiry';
$body = stripcslashes(html_entity_decode(stripcslashes($name))).' said:'."\n\n".

stripcslashes(html_entity_decode(stripcslashes($enquiry)))."\n\n".

stripcslashes(html_entity_decode(stripcslashes($name)))."\n".
stripcslashes(html_entity_decode(stripcslashes($email)))."\n".
stripcslashes(html_entity_decode(stripcslashes($tel)))."\n".
stripcslashes(html_entity_decode(stripcslashes($address)));
$headers = "From: ".$email;
mail ($to, $subject, $body, $headers);
?>

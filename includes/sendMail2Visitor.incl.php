<?php
// send mail to visitor
$to = $email;
$subject = 'Recipesjack enquiry';
$body = 'Dear '.$name.'

Thank you for your enquiry, we shall reply very shortly.

Recipesjack
';
$headers = "From: noreply@recipesjack.com";
mail ($to, $subject, $body, $headers);
?>
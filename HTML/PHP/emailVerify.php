<?php
	$hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.

	$to      = $email; // Send email to our user
	$subject = 'Signup | Verification'; // Give the email a subject 
	$message = '
 
	Thanks for signing up!
	Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
	------------------------
	Username: '.$name.'
	Password: '.$password.'
	------------------------
 
	Please click this link to activate your account:
	http://152.117.180.234/signupConfirm.html?email='.$email.'&hash='.$hash.'
 
	'; // Message that includes link
                     
	$headers = 'From:noreply@HomeUtilityManagement.com' . "\r\n"; // Set from header
	mail($to, $subject, $message, $headers); // Send email
?>
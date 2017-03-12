<?php
	$hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.
	// Example output: f4552671f8909587cf485ea990207f3b

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
 
	'; // Our message above including the link
                     
	$headers = 'From:noreply@HomeUtilityManagement.com' . "\r\n"; // Set from headers
	mail($to, $subject, $message, $headers); // Send our email
?>
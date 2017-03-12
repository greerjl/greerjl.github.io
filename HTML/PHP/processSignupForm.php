<?php

	$email = $pswd = $rpswd = "";
	$emailErr = $pswdErr = $rpswdErr = "";
	$hasErrors = false;

	if($_SERVER['REQUEST_METHOD']=='POST' && $_POST){
		$email = cleanData($_POST['email']);
			$emailErr = validate($email, 'email');
			if(!empty($emailErr)) $hasErrors = true;

		$pswd = cleanData($_POST['pswd']);
			$pswdErr = validate($pswd, 'password');
			if(!empty($pswdErr)) $hasErrors = true;

		$rpswd = cleanData($_POST['rpswd']);
			$rpswdErr = validate2($rpswd, $pswd);
			if(!empty($rpswdErr)) $hasErrors = true;
	}

	//FUNCTIONS
	function cleanData($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}//cleanData

	function validate($data, $field){
		switch($field){
			case 'email': {
				if(!empty($data)){
					if(!filter_var($data, FILTER_VALIDATE_EMAIL)){
						return "Invalid email address.";
					}//if
				}else{
					return "Email address is required.";
				}//ifelse
				return "";
			}//case email

			case 'password': {
				if(!empty($data)){
					if(!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/', $data)){
						return "Invalid password.";
					}//if
				}else{
					return "Must create a password.";
				}//ifelse
				return "";
			}//case pswd

			default: break;

		}//switch statement
	}//validate

	//data = rpswd, data2 = pswd
	function validate2($data, $data2){
			if(empty($data)){
				return "Please reenter password.";
			}else{
				if(strcmp($data, $data2) != 0){
					return "Passwords must match.";
				}//if
			}//ifelse
			return "";

	}//validate2

?>

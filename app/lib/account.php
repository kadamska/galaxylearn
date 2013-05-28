<?php

require "service.php";

function validate_signup() {
	// validate fields
	if (!$_REQUEST['email'] || !$_REQUEST['parent_email'] || !$_REQUEST['password']) {
		$error ="Please fill in all fields.";
		return $error;
	}

	if ($_REQUEST['email'] == $_REQUEST['parent_email']) {
		$error .=" Email addressses must be different.";
		return $error;
	}

	// check availability
	if (check_email_availability() == false) {
		$error ="That email address is already in use. Please use an alternate email.";
		return $error;
	}

	// register
	if (register_user() == false) {
		$error = "Cannot register user.";
		return $error;
	}
	// email parent

	return false;
}

function check_email_availability() {
	$UserService = new DataService('users');
	$matches = json_decode(
		$UserService->service_get(
			array('email' => $_REQUEST['email'])
		)
	);
	if( empty($matches)) {
		return true;
	}
	return false;
}

function register_user() {
	$UserService = new DataService('users');
	$data = array(
			'email' => $_REQUEST['email'],
			'parent_email' => $_REQUEST['parent_email'],
			'password' => $_REQUEST['password']
		);
	$user_id = $UserService->service_post($data);
	if ($user_id) {
		if (!send_parent_email($user_id)) {
			return faslse;
		}
		return true;
	}
	return false;
}

function authenticate() {
	$UserService = new DataService('users');
	$matches = json_decode(
		$UserService->service_get(
			array('email' => $_REQUEST['email'], 'password' => $_REQUEST['password'])
		), true
	);
	if( empty($matches)) {
		return $error = "We could not find an account with that email/password combination. Please try again.";
	}
	if( $matches[0]['authorized'] == false) {
		return $error = "Your parent or guardian has not authorized this account yet.";
	}
	$_SESSION['email'] = $_REQUEST['email'];
	$_SESSION['user_id'] = $matches[0]['_id']['$oid'];
	$_SESSION['admin'] = $matches[0]['admin'];
	header("Location: controlpanel.php");
}

function send_parent_email($user_id) {
	$url = $_SERVER["HTTP_HOST"] . "/terms.php?uid=" . $user_id;
	$link = "<a href='" . $url . "'>Click here</a>";
	$address = $_REQUEST['parent_email'];
	$subject = "Welcome to Galaxy Learn - Time Machine";
	$body = $link . " to read and agree to the Terms of Service.";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	if (!mail($address, $subject, $body, $headers)) {
		return false;
	}
	return true;
}

function activate_user($uid) {
	$UserService = new DataService('users');
	$User = $UserService->service_get_one($uid);
	$user = json_decode($User, true);
	$user["authorized"] = "1";
	$result = json_decode($UserService->service_update($uid, $user));
	if ($result) {
		mail($user["email"], "Welcome to GL Timemachine", "You may now log into your account." );
	}
	return true;
}

function restrict() {
	if ($_SESSION['user_id'] == 0) {
		header("Location: controlpanel.php");
	}
}

function send_email() {
	$uri = "https://mandrillapp.com/api/1.0/messages/send.json?key=TfwBVbcI1N54lNqfsAEL6A";
	$data = array (
		"key" => "TfwBVbcI1N54lNqfsAEL6A",
		"message" =>
			array (
				"html"=> "this is the emails html content",
		    	"text"=> "this is the emails text content",
		    	"subject" => "this is the subject",
		    	"from_email" => "mcafee.sam@gmail.com",
		    	"from_name" => "John",
		    	"to" => array(
		    				array("email" => "sam@radicalfusion.net", "name" => "Bob"),
		    				array("email" => "sam@radicalfusion.net", "name" => "Bob")
		    			),
		    	"headers" => array()
		    ),
		"async" => "false"
		);	
	$postfields = json_encode($data);
	$ch = curl_init($uri);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	    'Content-Type: application/json',                                                                                
	    'Content-Length: ' . strlen($postfields))                                                                       
	);                                                                                                                   
	
	$result = curl_exec($ch);
	curl_close($ch);
    return $result;
}

?>
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
	$url = $_SERVER["HTTP_HOST"] . APPLICATION_ROOT. "/terms.php?uid=" . $user_id;
	$link = "<a href='" . $url . "'>Click here</a>";
	$email_values = array(
			'message_html_body' => $link . " to read and agree to the Terms of Service.",
			'message_subject' => "Welcome to Galaxy Learn - Time Machine",
			'message_recipients' => array(
			    				array("email" => $_REQUEST['parent_email'])
			    			)
		);
	
	$sent = send_email($email_values);
	if (!$sent) {
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
	if ($user['email']) {
		$email_values = array(
				'message_html_body' => "You may now log into your account. <a href='" . $_SERVER['HTTP_HOST'] . APPLICATION_ROOT . "/sign-in.php'>Galaxy Learn</a>",
				'message_subject' => "Welcome to GL Timemachine",
				'message_recipients' => array(
				    				array("email" => $user['email'])
				    			)
			);
		send_email($email_values);
	}
	return true;
}

function restrict() {
	if ($_SESSION['user_id'] == 0) {
		header("Location: controlpanel.php");
	}
}

function send_email($values) {
	$uri = "https://mandrillapp.com/api/1.0/messages/send.json?key=TfwBVbcI1N54lNqfsAEL6A";
	$data = array (
		"key" => "TfwBVbcI1N54lNqfsAEL6A",
		"message" =>
			array (
				"html"=> $values['message_html_body'],
		    	"text"=> $values['message_text_body'],
		    	"subject" => $values['message_subject'],
		    	"from_email" => "info@galaxylearn.com",
		    	"from_name" => "Time Machine",
		    	"to" => $values['message_recipients'],
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
	error_log("message sent through Mandrill: ". $postfields);
	$result = curl_exec($ch);
	error_log("result from Mandrill: ". $result);
	curl_close($ch);
    return $result;
}

?>
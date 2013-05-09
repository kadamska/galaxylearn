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
		error_log("register_user returned false");
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
	error_log( "got this from mongo: " . $user_id);
	if ($user_id) {
		if (!send_parent_email($user_id)) {
			error_log(" Could not send parent email ");
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
	header("Location: controlpanel.php");
}

function send_parent_email($user_id) {
	$url = $_SERVER["HTTP_HOST"] . "/terms.php?uid=" . $user_id;
	$link = "<a href='" . $url . "'>Click here</a>";
	$address = $_REQUEST['parent_email'];
	$subject = "Welcome to Galaxy Learn - Time Machine";
	$body = $link . " to read and agree to the Terms of Service.";
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	if (mail($address, $subject, $body, $headers)) {
		return true;
	}
	return false;
}

?>
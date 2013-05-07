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
		$_SESSION['user_id'] = $user_id;
		$_SESSION['email'] = $_REQUEST['email'];
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
	$_SESSION['user_id'] = $matches[0]['_id']['$oid'];
	return false;
}

?>
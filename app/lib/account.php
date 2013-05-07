<?php

require "service.php";

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
		return true;
	}
	return false;
}

?>
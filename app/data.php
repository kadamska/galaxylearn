<?php

require_once "_config.php";

if ($_REQUEST['type'] == "eras") {
	$DataService = new DataService('eras');
	$eras = $DataService->service_get();
	echo $eras;

}

if ($_REQUEST['type'] == "stories") {
	$DataService = new DataService('stories');
	$params = array("era_id" => intval($_REQUEST['eraId']), "status" => 2);
	$stories = $DataService->service_get($params);
	echo $stories;

}

if ($_REQUEST['type'] == "user_stories_drafts") {
	$DataService = new DataService('stories');
	$params = array("status" => 0);
	if ($_SESSION['user_id'] != 0) {
	 	$params["user"] = $_SESSION['user_id'];
	}
	$stories = $DataService->service_get($params);
	echo $stories;

}

if ($_REQUEST['type'] == "user_stories_submitted") {
	$DataService = new DataService('stories');
	$params = array("status" => 1);
	if ($_SESSION['user_id'] != 0) {
	 	$params["user"] = $_SESSION['user_id'];
	}
	$stories = $DataService->service_get($params);
	echo $stories;

}

if ($_REQUEST['type'] == "story") {
	$DataService = new DataService('stories');
	$story = $DataService->service_get_one($_REQUEST['storyId']);
	echo $story;
}

if ($_REQUEST['type'] == "newstory") {
	$inputJSON = file_get_contents('php://input');
	$input= json_decode( $inputJSON, TRUE );
	$DataService = new DataService('stories');
	$data =	array (
				"user" => $_SESSION['user_id'],
				"era_id" =>  $input['era_id'], 
				"title" =>  $input['title'], 
				"img" =>  $input['img'],
				"status" => 0, 
				"body" => $input['body']);
	if ($input['id'] != '') {
		$story = $DataService->service_update($input['id'],	$data);
	}
	else {
		$story = $DataService->service_post($data);
	}
		

}

if ($_REQUEST['type'] == "submitStory") {
	$inputJSON = file_get_contents('php://input');
	$input= json_decode( $inputJSON, TRUE );
	$DataService = new DataService('stories');
	$data =	array (
				"user" => $_SESSION['user_id'],
				"era_id" =>  $input['era_id'], 
				"title" =>  $input['title'], 
				"img" =>  $input['img'],
				"status" => $input['status'], 
				"body" => $input['body']);
	$story = $DataService->service_update($input['id'],	$data);
		

}

if ($_REQUEST['type'] == "acceptStory") {
	if (!$_SESSION['admin']) {
		header("Location: " . APPLICATION_ROOT);
	}
	$DataService = new DataService('stories');
	$story = $DataService->service_get_one($_REQUEST['id']);
	$array = json_decode($story, TRUE);
	$array['status'] = 2;
	$array['era_id'] = intval($array['era_id']);
	$story = $DataService->service_update($_REQUEST['id'],	$array);
	$UserService = new DataService("users");
	$user = $UserService->service_get_one($array['user']);
	$user = json_decode($user, TRUE);
	$email_values = array(
				'message_html_body' => "Congratulations! Your adventure has been reviewed and accepted by the Time Machine and everyone can now enjoy it.",
				'message_subject' => "Time Machine Submission Accepted",
				'message_recipients' => array(
				    				array("email" => $user['email'])
				    			)
			);
	send_email($email_values);
	header("Location: workbench.php");
}


if ($_REQUEST['type'] == "rejectStory") {
	if (!$_SESSION['admin']) {
		header("Location: " . APPLICATION_ROOT. "/workbench.php");
	}
	$DataService = new DataService('stories');
	$story = $DataService->service_get_one($_REQUEST['id']);
	$array = json_decode($story, TRUE);
	$array['status'] = 3;
	$story = $DataService->service_update($_REQUEST['id'],	$array);
	$UserService = new DataService("users");
	$user = $UserService->service_get_one($array['user']);
	$user = json_decode($user, TRUE);
	$email_values = array(
				'message_html_body' => "Sorry! Your adventure has been reviewed but was accepted by the Time Machine.",
				'message_subject' => "Time Machine Submission Rejected",
				'message_recipients' => array(
				    				array("email" => $user['email'])
				    			)
			);
	send_email($email_values);
	header("Location: workbench.php");
}

if ($_REQUEST['type'] == "submittedstories") {
	$DataService = new DataService('stories');
	$params = array("status" => 1);
	$stories = $DataService->service_get($params);
	echo $stories;

}

if ($_REQUEST['type'] == "authenticated") {
	$array = array('user_id' =>  $_SESSION['user_id'], 'admin' => $_SESSION['admin']);
	echo json_encode($array);
}


?>
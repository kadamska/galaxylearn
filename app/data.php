<?php

// Stories Statuses
// Draft 	 = 0
// Submitted = 1
// Published = 2

require_once "_config.php";

if ($_REQUEST['type'] == "eras") {
	$DataService = new DataService('eras');
	$eras = $DataService->service_get();
	echo $eras;
	return;
}

if ($_REQUEST['type'] == "stories") {
	$DataService = new DataService('stories');
	$params = array("era_id" => intval($_REQUEST['eraId']), "status" => 2);
	$stories = $DataService->service_get($params);
	echo $stories;
	return;
}

if ($_REQUEST['type'] == "user_stories_drafts") {
	$DataService = new DataService('stories');
	$params = array("status" => 0);
	if ($_SESSION['user_id'] != 0) {
	 	$params["user"] = $_SESSION['user_id'];
	}
	$stories = $DataService->service_get($params);
	echo $stories;
    return;
}

if ($_REQUEST['type'] == "user_stories_submitted") {
	$DataService = new DataService('stories');
	$params = array("status" => 1);
	if ($_SESSION['user_id'] != 0) {
	 	$params["user"] = $_SESSION['user_id'];
	}
	$stories = $DataService->service_get($params);
	echo $stories;
    return;
}

if ($_REQUEST['type'] == "story") {
	$DataService = new DataService('stories');
	$story = $DataService->service_get_one($_REQUEST['storyId']);
	echo $story;
	return;
}

if ($_REQUEST['type'] == "newstory") {
	$inputJSON = file_get_contents('php://input');
	$input= json_decode( $inputJSON, TRUE );
	$DataService = new DataService('stories');
	if (!$_SESSION['admin']) {
		$data =	array (
			"user" => $_SESSION['user_id'], // if is admin, doesn't change this.
			"username" => $_SESSION['screenName'],
			"era_id" =>  $input['era_id'], 
			"title" =>  $input['title'], 
			"img" =>  $input['img'],
			"status" => 0, 
			"body" => $input['body'],
			"allages" =>  $input['allages'],
			"age" =>  $input['age']);
	} else {
		$data =	array (
			"user" => $_SESSION['user_id'], 
			"username" => $_SESSION['screenName'],
			"era_id" =>  $input['era_id'], 
			"title" =>  $input['title'], 
			"img" =>  $input['img'],
			"status" => 1, 
			"body" => $input['body'],
			"allages" =>  $input['allages'],
			"age" =>  $input['age']);		
	}
	if ($input['id'] != '') {
		$story = $DataService->service_update($input['id'],	$data);
		$actualStory = $DataService->service_get_one($input['id']);		
	}
	else {
		$story = $DataService->service_post($data);
		$actualStory = $DataService->service_get_one($story);
	}
	echo $actualStory;	
	
}

if ($_REQUEST['type'] == "submitStory") {
	$inputJSON = file_get_contents('php://input');
	$input= json_decode( $inputJSON, TRUE );
	$DataService = new DataService('stories');
	$data =	array (
		"user" => $_SESSION['user_id'],
		"username" => $_SESSION['screenName'],
		"era_id" =>  $input['era_id'], 
		"title" =>  $input['title'], 
		"img" =>  $input['img'],
		"age" =>  $input['age'],
		"allages" =>  $input['allages'],
		"status" => $input['status'], 
		"body" => str_replace("\n", "<br>", ($input['body']))
	);
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
		'message_recipients' => array(array("email" => $user['email']))
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
				'message_html_body' => "Your Adventure was not accepted by the Time Machine. Please review Terms of Service and try again. Thanks!",
				'message_subject' => "Time Machine Submission Rejected",
				'message_recipients' => array(
				    				array("email" => $user['email'])
				    			)
			);
	send_email($email_values);
	header("Location: workbench.php");
}

if ($_REQUEST['type'] == "deleteStory") {
	if (!$_SESSION['admin']) {
		header("Location: " . APPLICATION_ROOT. "/workbench.php");
	}
	$DataService = new DataService('stories');
	$story = $DataService->service_get_one($_REQUEST['id']);
	$array = json_decode($story, TRUE);

	$UserService = new DataService("users");
	$user = $UserService->service_get_one($array['user']);
	$user = json_decode($user, TRUE);
	$email_values = array(
				'message_html_body' => "Sorry! Your adventure has been deleted by the Time Machine.",
				'message_subject' => "Time Machine Submission Deleted",
				'message_recipients' => array(
				    				array("email" => $user['email'])
				    			)
			);
	send_email($email_values);

	$deletion = $DataService->service_delete($_REQUEST['id']);

	header("Location: controlpanel.php");
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

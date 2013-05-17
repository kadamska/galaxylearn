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
?>
<?php

require "service.php";
require "email.php";

function validate_signup() 
{
	// validate fields
	if (!$_REQUEST['email'] || !$_REQUEST['parent_email'] || !$_REQUEST['password'] || !$_REQUEST['screenName']) {
		$error = "Please fill in all fields.";
		return $error;
	}

	if ($_REQUEST['email'] == $_REQUEST['parent_email']) {
		$error = "Email addresses must be different.";
		return $error;
	}

	// check availability
	if (check_email_availability() == false) {
		$error = "The email \"" . $_REQUEST['email'] . "\" is already in use. Please enter a different email.";
		return $error;
	}

	// register and email parent
	if (!registerUser($_REQUEST['email'], $_REQUEST['parent_email'], $_REQUEST['password'], $_REQUEST['screenName'])) {
		$error = "Cannot register user.";
		return $error;
	}
	
	return false;
}

function check_email_availability() 
{
	$UserService = new DataService('users');
	$matches = json_decode($UserService->service_get(array('email' => $_REQUEST['email'])), true);
	if (empty($matches)) {
		return true;
	}
	
	// delete TODO test
	$UserService->service_delete($matches[0]['_id']['$oid']);
	return true;
	
	return false;
}

/**
 * Register user
 * @param string $userEmail user email
 * @param string $parentEmail parent email
 * @param string $password password
 * @return boolean true if registered, false otherwise
 */
function registerUser($userEmail, $parentEmail, $password, $screenName)
{
	$userService = new DataService('users');
	$data = array(
		'email' => $userEmail,
		'parent_email' => $parentEmail,
		'password' => $password,
	    'screen_name' => $screenName
	);
	
	$userId = $userService->service_post($data);
	
	if ($userId) {
		if (!send_parent_email($userId, $parentEmail)) {
		    // roll back user creation if the email has not been sent
		    $userService->service_delete($userId);
			return false;
		}
		return true;
	}
	
	return false;
}

/**
 * Authenticate user
 * @return string
 */
function authenticate() 
{
	$UserService = new DataService('users');
	$matches = json_decode(
		$UserService->service_get(
			array('email' => $_REQUEST['email'], 'password' => $_REQUEST['password'])
		), true
	);
	
	if (empty($matches)) {
		return 'We could not find an account with that email/password combination. Please try again.';
	}
	
	$user = $matches[0];
	//print_r($user);
	//return;
	
	if (!array_key_exists('authorized', $user) || !$user['authorized']) {
		return 'Your parent or guardian has not authorized this account yet.';
		//activateUser('52360878e4b0d93062d9e134');
	}
	
	$_SESSION['user_id'] = $user['_id']['$oid'];
	$_SESSION['email'] = $user['email'];
	$_SESSION['admin'] = $user['admin'];
	$_SESSION['screenName'] = $user['screen_name'];
	
	header("Location: controlpanel.php");
}

/**
 * Send registration email to parent
 * @param integer $user_id child user id
 * @return boolean true if sent, false otherwise
 */
function send_parent_email($user_id, $parentEmail) 
{
	$tosLink = $_SERVER["HTTP_HOST"] . APP_WEB_ROOT. "/terms.php?uid=" . $user_id;
	$websiteLink = $_SERVER["HTTP_HOST"] . APP_WEB_ROOT . "/index.php";
	
	$emailBody = "<h3>Welcome to Galaxy Learn's Time Machine!</h3>"
	    . "<p>Your child or student has applied to be a crewmember in the Time"
	    . " Machine. He or she will be able to write, add images, research"
	    . " history and collaborate with other student crewmembers on the site."
	    . " No student will have any direct email or online contact with another"
	    . " student or adult, and all work submitted will be reviewed by their"
	    . " teacher and the Time Machine staff.</p>"
	    . "<p>You may visit our main website to find out more about"
	    . " <a href=\"www.galaxylearn.com\">Galaxy Learn</a> and"
	    . " the <a href=\"{$websiteLink}\">Time Machine</a> historical simulator."
	    . "<p>Your approval is required for your child to start using our service."
	    . " <a href=\"{$tosLink}\">Click here</a> to read and agree to the Terms of Service.</p>";
	
	$email = new Email();
	$email->setSubject("Welcome to Galaxy Learn's Time Machine!");
	$email->setHtmlBody($emailBody);
	$email->addToRecipient($parentEmail);
	
	return $email->send();
}

/**
 * Activate user account
 * @param string $uid user id
 * @throws Exception
 */
function activateUser($uid) 
{
    $userService = new DataService('users');
	$user = $userService->service_get_one($uid);
	
	if (!$user) {
	    throw new Exception('Could not find user account.');
	}
	
	$userDecoded = json_decode($user, true);
	$userDecoded['authorized'] = '1';
	
	$updated = json_decode(
	    $userService->service_update($uid, $userDecoded)
	);
	
	if (!$updated) {
	    throw new Exception('Could not update user account.');
	}
	
	// send confirmation email
	$link = $_SERVER['HTTP_HOST'] . APP_WEB_ROOT . '/sign-in.php';
	$htmlBody = "<h3>Welcome to Galaxy Learn's Time Machine!</h3>";
	$htmlBody .= "<p>Your account has been activated! You may now log in."
	    . " Go to <a href=\"$link\">Galaxy Learn</a></p>";
	
	$email = new Email();
	$email->setSubject("Welcome to Galaxy Learn's Time Machine!");
	$email->setHtmlBody($htmlBody);
	$email->addToRecipient($userDecoded['email']);
	$email->send();
}

function restrict() 
{
	if ($_SESSION['user_id'] == 0) {
		header("Location: controlpanel.php");
	}
}

function send_email($values) 
{
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
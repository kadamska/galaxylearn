<?php

function logout() {
	session_destroy();
	header("Location: /");
	exit;
}

session_start();
//var_dump($_SESSION);
//session_destroy();

?>
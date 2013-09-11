<?php
session_set_cookie_params(2592000, '/');
session_start();

function logout($url) {
	session_destroy();
	header("Location: ".$url);
}

?>
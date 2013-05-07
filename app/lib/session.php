<?php
function logout() {
	session_destroy();
	header("Location: /");
}

function login() {
	session_set_cookie_params(2592000, '/');
	session_start();
}

?>
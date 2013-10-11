<?php

define('APP_WEB_ROOT', '/galaxylearn/app');
define('CONTACT_EMAIL', 'CatherineOatesGL@gmail.com');

if ($_SERVER["HTTP_HOST"] == "gl-timemachine.herokuapp.com") {
	define("APPLICATION_ROOT", "/app");
}
else {
	define("APPLICATION_ROOT", "/");
}

require_once "lib/session.php";
require_once "lib/account.php";


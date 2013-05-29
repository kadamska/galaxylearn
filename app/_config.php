<?php
if ($_SERVER["HTTP_HOST"] == "gl-timemachine.herokuapp.com") {
	define("APPLICATION_ROOT", "/app");
}
else {
	define("APPLICATION_ROOT", "/");
}
require_once "lib/session.php";
require_once "lib/account.php";


?>
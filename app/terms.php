<?php

require "lib/session.php";
require "lib/service.php";

if ($_REQUEST['activate-submit']) {

	$error = activate_user();

	if ($error == "") {

		// display confirmation
		header("Location: /");
	}
}

require "header.php";

?>


			<div class="row">
				<div class="span12">
					<h3>Terms of Service</h3>
<iframe class="span8" src="https://docs.google.com/document/d/1EWcu5IAjpm-EvE0W3J24-nmLve6ahu-UdExs_A4jUzg/pub?embedded=true"></iframe>
				</div>
			</div>
			<div class="row">
				<div class="span12">
				<form action="terms.php" method="POST">
					<input type="hidden" value="<?php $_RESQUEST['uid'] ?>" name="uid">
					<input type="checkbox" name="accept"> I accept the terms and conditions.
					<button name="activate-submit" class="btn btn-primary btn-large">Accept</button>
				</div>
			</div>
			
<?php
require "footer.php";
?>
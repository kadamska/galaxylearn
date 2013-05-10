<?php

require "lib/session.php";
require "lib/account.php";

if ($_REQUEST['activate-submit']) {

	activate_user($_REQUEST['uid']);
	header("Location: /");
}

if (!$_REQUEST['uid']) {
	header("Location: /");
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
					<input type="hidden" value="<?= $_REQUEST['uid'] ?>" name="uid">
					<input type="checkbox" name="accept"> I accept the terms and conditions.
					<button name="activate-submit" value="true" class="btn btn-primary btn-large">Accept</button>
				</form>
				</div>
			</div>
			
<?php
require "footer.php";
?>
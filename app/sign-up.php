<?php
require_once "_config.php";
$error = false;
if (array_key_exists('signup-submit', $_REQUEST)) {
	$error = validate_signup();
	if (!$error) {
		// display confirmation
		header("Location: " . APP_WEB_ROOT . "/confirmation.php");
	}
}
require "header.php";
?>
<div class="row">
	<div class="span8"><img src="img/changetime.jpg" /></div>
	<div class="span4">
		<h3>Sign up for an account:</h3>
		<?php if ($error) { ?>
		    <div class="alert alert-error"><?php echo $error; ?></div>
		<?php } ?>
			<form action="sign-up.php" method="POST">
				<label>Your email address</label>
				<input type="text" name="email" value="<?php if (array_key_exists('email', $_REQUEST)) { echo $_REQUEST['email']; } ?>">
				<label>Your parent's or guardian's email address</label>
				<input type="text" name="parent_email" value="<?php if (array_key_exists('parent_email', $_REQUEST)) { echo $_REQUEST['parent_email']; } ?>">
				<label>Choose a password</label>
				<input type="password" name="password" value="<?php if (array_key_exists('password', $_REQUEST)) { echo $_REQUEST['password']; } ?>">
				<label>Choose a screen name</label>
				<input type="text" name="screenName" value="<?php if (array_key_exists('screenName', $_REQUEST)) { echo $_REQUEST['screenName']; } ?>">
				<br>
				<input type="submit" class="btn btn-large btn-primary" name="signup-submit" value="Submit" />
			</form>
	</div>
</div>
<?php
require "footer.php";

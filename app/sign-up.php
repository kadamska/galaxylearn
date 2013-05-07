<?php
require "lib/session.php";
require "lib/account.php";

if ($_REQUEST['signup-submit']) {

	// validate fields
	if (!$_REQUEST['email'] || !$_REQUEST['parent_email'] || !$_REQUEST['password']) {
		$error ="Please fill in all fields.";
	}

	if ($_REQUEST['email'] == $_REQUEST['parent_email']) {
		$error .=" Email addressses must be different.";
	}

	// check availability
	if (check_email_availability() == false) {
		$error ="That email address is already in use. Please use an alternate email.";
	}

	// register
	register_user();

	// email parent
	header("Location: confirmation.php");
	exit;
}
require "header.php";

?>
		<div class="row">
			<div class="span8"><img src="img/changetime.jpg" /></div>
			<div class="span4">

				<h3>Sign up</h3>
				<?php if ($error) { ?><div class="alert alert-error"><?php echo $error; ?></div><?php } ?>

					<form action="sign-up.php">
						<label>Your email address</label>
						<input type="text" name="email" value="<?=$_REQUEST['email'] ?>">
						<label>Your parent's or guardian's email address</label>
						<input type="text" name="parent_email" value="<?=$_REQUEST['parent_email'] ?>">
						<label>Choose a password</label>
						<input type="password" name="password" value="<?=$_REQUEST['password'] ?>">
						<br>
						<button class="btn btn-large btn-primary" name="signup-submit" value="true">Submit</input>
					</form>

			</div>
		</div>
		  
<?php
require "footer.php";
?>
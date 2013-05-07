<?php
require "lib/session.php";
require "lib/account.php";

if ($_REQUEST['signup-submit']) {

	$error = validate_signup();

	if ($error == "") {

		// display confirmation
		header("Location: confirmation.php");
	}
}
require "header.php";

?>
		<div class="row">
			<div class="span8"><img src="img/changetime.jpg" /></div>
			<div class="span4">

				<h3>Sign up for an account:</h3>
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
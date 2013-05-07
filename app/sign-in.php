<?php
require "lib/session.php";
require "lib/account.php";

if ($_REQUEST['signin-submit']) {

	// check sign-up info
	if (!$error = authenticate()) {
		header("Location: controlpanel.php");
		exit;
	}
}
require "header.php";

?>
		<div class="row">
			<div class="span8"><img src="img/changetime.jpg" /></div>
			<div class="span4">

				<h3>Sign in to your account:</h3>
				<?php if ($error) { ?><div class="alert alert-error"><?php echo $error; ?></div><?php } ?>

					<form action="sign-in.php">
						<label>Your email address</label>
						<input type="text" name="email" value="<?=$_REQUEST['email'] ?>">
						<label>Your password</label>
						<input type="password" name="password" value="<?=$_REQUEST['password'] ?>">
						<br>
						<button class="btn btn-large btn-primary" name="signin-submit" value="true">Sign in</input>
					</form>

			</div>
		</div>
		  
<?php
require "footer.php";
?>
<?php
require "_config.php";

$error = false;
if (array_key_exists('signin-submit', $_REQUEST)) {
	// check sign-up info
	$error = authenticate();
}
require "header.php";
?>
<div class="row">
	<div class="span8"><img src="img/changetime.jpg" /></div>
	<div class="span4">
		<h3>Log in to your account:</h3>
		<?php if ($error) { ?><div class="alert alert-error"><?php echo $error; ?></div><?php } ?>
			<form action="sign-in.php" method="POST">
				<label>Your email address</label>
				<input type="text" name="email" value="<?php if (array_key_exists('email', $_REQUEST)) { echo $_REQUEST['email']; }  ?>">
				<label>Your password</label>
				<input type="password" name="password" value="<?php if (array_key_exists('password', $_REQUEST)) { echo $_REQUEST['password']; } ?>">
				<br>
				<input type="submit" class="btn btn-large btn-primary" name="signin-submit" value="Sign in" />
			</form>
	</div>
</div>
<?php
require "footer.php";

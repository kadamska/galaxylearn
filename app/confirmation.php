<?php
require_once "_config.php";
require_once "header.php";
?>
<div class="span10 hero-unit" style="background-color:#666;">
  <h1>Confirmation</h1>
  <p>Thank you for signing up. You will receive an email with a confirmation link.</p>
  <p>
    <a class="btn btn-primary btn-large" href="<?php echo APP_WEB_ROOT . '/index.php'; ?>">
      Home
    </a>
  </p>
</div>
<?php
require "footer.php";

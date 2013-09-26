<?php

require_once "_config.php";
$error = false;

// no user id to activate
if (!$_REQUEST['uid']) {
    header("Location: " . APP_WEB_ROOT . "/index.php");
}

// process activation form
if (array_key_exists('activate-submit', $_REQUEST)) {
    
    if (!array_key_exists('accept', $_REQUEST)) {
        
        $error = 'You must accept terms of service to activate the child account.';
        
    } else {
        
        try {
            
            activateUser($_REQUEST['uid']);
	        header("Location: " . APP_WEB_ROOT . "/index.php");
	        
	    } catch (Exception $e) {
	        
	        $error = 'Sorry, there was an error activating account: ' . $e->getMessage();
	        
	    }
	    
	}
	
}
require "header.php";
?>
<?php if ($error) { ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php } ?>
<div class="row">
	<div class="span12">
		<h3>Terms of Service</h3>
        <iframe class="span8" src="https://docs.google.com/document/d/1EWcu5IAjpm-EvE0W3J24-nmLve6ahu-UdExs_A4jUzg/pub?embedded=true"></iframe>
	</div>
</div>
<div class="row">
	<div class="span12">
    	<form name="activate-user-form" action="<?php echo APP_WEB_ROOT; ?>/terms.php" method="POST">
    		<input type="hidden" name="uid" value="<?php echo $_REQUEST['uid']; ?>" />
    		<input type="checkbox" name="accept" value="1" /> I accept the terms and conditions.
    		<input type="submit" name="activate-submit" value="Accept" class="btn btn-primary btn-large" />
    	</form>
	</div>
</div>
<?php
require "footer.php";

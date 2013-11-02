<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Time Machine - Go Somewhen</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/app.css" />
  <script src="js/bootstrap.min.js"></script>
</head>
<?php 
	$loggedIn = array_key_exists('user_id', $_SESSION) && !empty($_SESSION['user_id']);
?>
<body style="background-color:#000; color:#fff;">
<div class="container">
  <div class="row" style="margin-top:25px;">  
        <div class="span12" style="text-align: right;">
      	  <div class="span12">
        	 <ul id="mainnav" class="nav nav-pills">
              	<li><a href="index.php">Home</a></li>
              	<?php if (!$loggedIn) { ?>
              	    <li><a href="sign-in.php">Log In</a></li>
              	<?php } ?>
              	<?php if ($loggedIn) { ?>
              		<li><a href="workbench.php">Workbench</a></li>
              	<?php } ?>
              	<li><a href="controlpanel.php">Control Panel</a></li>
              	<?php if (!$loggedIn) { ?>  
              	    <li><a href="sign-up.php">Register</a></li>
              	<?php } ?>
              	<li><a href="about.php">About</a></li>
    		</ul>
  		  </div>
  		  <?php if ($loggedIn) { ?>
  		  <div id="loggedin" class="span12" style="margin-top:7px;">
  		    Welcome, <?php echo $_SESSION['screenName'] ? $_SESSION['screenName'] : $_SESSION['email']; ?>
  		    | <a href="sign-out.php?url=<?php echo $_SERVER['PHP_SELF']; ?>">Logout</a>
          </div>
          <?php } ?>  
  	</div>	
  </div>
  <div class="row home-main-title">
    <div class="span12" style="margin-top:45px; margin-bottom: 10px;">
       <h1 style="font-size:90px; font-family: 'Tangerine', cursive; text-align: center;" >
          <a href="<?php echo 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']); ?>/controlpanel.php" style="color:#fff; text-decoration:none; ">Time Machine</a>
       </h1>
       <br>
       <h2 class="home-subtitle pull-right">Go somewhen</h2>
      </div>
  </div>
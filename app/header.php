<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Time Machine - Go Somewhen</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/app.css" />
</head>
<?php 
	$loggedIn = array_key_exists('user_id', $_SESSION) && !empty($_SESSION['user_id']);
?>
<body style="background-color:#000; color:#fff;">
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
    <div class="span12" style="margin-top:20px; margin-bottom: 5px;">
       <h1 style="text-align: center;">
          <a href="<?php echo 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']); ?>/controlpanel.php" style="color:#fff; text-decoration:none; ">
              <img src="img/tm-logo.png">
          </a>
       </h1>
       <br>
       <h2 class="home-subtitle pull-right">
           <img src="img/go-somewhen.png">
       </h2>
      </div>
  </div>
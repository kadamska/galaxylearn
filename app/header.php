<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Time Machine - Go Somewhen</title>
  <link rel="stylesheet" href="css/app.css"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--<link href="css/skin2.css" rel="stylesheet">-->
  <script src="js/bootstrap.min.js"></script>
  
</head>
<body style="background-color:#000; color:#fff;">
<div class="container">
  <div class="row" style="margin-top:25px;">  
        
        <div class="span12" style="text-align: right;">
      	
      	  <div class="span12">
        	 	<ul id="mainnav" class="nav nav-pills">
              	<li><a href="index.php">Home</a></li>
              	<li><a href="controlpanel.php">Control Panel</a></li>
              	<?php if ($_SESSION['user_id']) { ?>
              	<li><a href="workbench.php">Workbench</a></li>
              	<?php } ?>
              	<?php if ($_SESSION['user_id'] == '') { ?>
              	<li><a href="sign-in.php">Login</a></li>
                <li><a href="sign-up.php">Sign up</a></li>
             		<?php } ?>
                <li><a href="about.php">About</a></li>
    			</ul>
  		  </div>
  		  
  		  <div id="loggedin" class="span12" style="margin-top:7px;">
         		<?php if ($_SESSION['user_id']) { ?>Logged in as <?php echo $_SESSION['email'] ?> | <a href="sign-out.php?url=<?php echo $_SERVER['PHP_SELF']; ?>">(Logout)</a>
				<?php } ?>
          </div>  

  	</div>	
  </div>
  
  <div class="row home-main-title">
      <div class="span12" style="margin-top:45px; margin-bottom: 35px;">
        <a href="#" onclick="window.location.href='<?php echo 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']); ?>/controlpanel.php'" style="color:#fff; text-decoration:none; "> <h1 style="font-size:90px; font-family: 'Tangerine', cursive; text-align: center;" >Time Machine</h1></a>
        <br>
        <h2 class="home-subtitle pull-right">Go somewhen</h2>
      </div>
  </div>
  
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Time Machine - Go Somewhen</title>
  <link rel="stylesheet" href="css/app.css"/>
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
</head>
<body style="background-color:#000; color:#fff;">
<div class="container">
  <div class="row">
      
      <div class="span7">
          <br>
        <h1 style="font-size:90px;">Time Machine</h1>
        <br>
          <h2 style="font-size:60px; color:#dba622" class="offset2">Go somewhen.</h2>
      </div>
      
      <div class="span5">
      	<div>
      	 <ul class="nav nav-pills">
            <li><a href="index.php">Home</a></li>
            <li><a href="controlpanel.php">Control Panel</a></li>
            <?php if (session_id()) { ?>
            <li><a href="workbench.php">Workbench</a></li>
            <?php } ?>
            <li><a href="about.php">About</a></li>
            <li><a href="sign-in.php">Login</a></li>
  			 </ul>
  		  </div>
      </div>
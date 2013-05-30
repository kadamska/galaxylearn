<?php

require_once "_config.php";

require_once "header.php";

?>


			<div class="row">
				<div class="span8"><img src="img/changetime.jpg" /></div>
				<div class="span4">
					<p class="homepage-text">Have you always wanted to time travel? Become a crew member in the Time Machine Workshop. We need researchers, writers, editors, image editors and beta testers to build the Time Machine, made by kids, for kids.</p>


            <?php if (!$_SESSION['user_id']) { ?>

					<div align=center>
						<button class="btn btn-primary btn-large homepage-button" id = "signup" onclick="window.location.href='sign-up.php'">Sign-up</button>
					</div>
            <?php } ?>
					<div align=center>
						<button class="btn btn-primary btn-large homepage-button" onclick="window.location.href='controlpanel.php'">Go on Adventures in Time!</button>
					</div>
				</div>
			</div>
		  
<?php
require "footer.php";
?>
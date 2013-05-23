<?php 


require_once "_config.php";
restrict();
require "header.php";

?>
			<div ng-app="wbApp">
			<div class="row">
				<div class="span12">
					<h3>Work Bench</h3>
					<button class="btn btn-primary" onclick="window.location.href='#/drafts'">DRAFT</button>
					<button class="btn btn-primary" onclick="window.location.href='#/submitted'">SUBMITTED</button>
					<button class="btn btn-primary" onclick="window.location.href='#/story/create'">CREATE NEW</button>

				</div>
			</div>
			<div ng-view></div>
		  	</div>
<?php
require "footer.php";
?>
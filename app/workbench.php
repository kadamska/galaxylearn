<?php 


require_once "_config.php";
restrict();
require "header.php";

?>
			<div ng-app="wbApp">
			<div class="row">
				<div class="span12">
<?php
			if ($_SESSION['admin']) {
?>
			
			<h3>Ready for Review</h3>
					<ul ng-controller="AdminReviewCtrl">
						<li class="span4" ng-repeat="story in stories">
						<div class="thumbnail">
							<a href="controlpanel.php#/story/{{story._id.$oid}}" >{{story.title}}<img src="{{story.img}}" ></a>
						</div>
						</li>
					</ul>
				</div>
			</div>
<?php
			} else {
?>
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
			}
require "footer.php";
?>
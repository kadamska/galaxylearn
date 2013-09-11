<?php

require_once "_config.php";

require "header.php";

?>


			<div class="row" ng-app="myApp">
				<div class="span12 mycarousel" ng-controller="MainCtrl">
					<!--<h3>Pick an Era</h3>-->
						<hr class="skyblue-line">
						<ul id="pickera" class="thumbnails">
						    <li ng-repeat="era in eras">
						    <a href="#/era/{{era.id}}/{{era.name}}">
						    	<img width="110" style="margin-left:auto;margin-right:auto;display:block;" src="img/{{era.img}}"/>
						    	<br><br>
						    	<p>{{era.name}}
						    	<br><br>
						    	{{era.times}}</p>
						    </a>
						    </li>
						</ul>

						<hr class="skyblue-line">
						<div class="era-loadview" ng-view></div>
				</div>
			</div>
		  
<?php
require "footer.php";
?>
<?php

require_once "_config.php";

require "header.php";

?>


			<div class="row" ng-app="myApp">
				<div class="span12"  ng-controller="MainCtrl">
					<div align="center">
					<h3>Pick an Era</h3>
						<hr>
						<ul style="border: 1px solid white;text-align:center;" class="thumbnails" >
						    <li ng-repeat="era in eras">
						    <a href="#/era/{{era.id}}/{{era.name}}" >
						    	{{era.name}}
						    	<br>
						    	<img width="90" src="img/{{era.img}}"/>
						    	<br>
						    	{{era.times}}
						    </a>
						    </li>
						</ul>
						<hr>
						<div ng-view></div>
					</div>
				</div>
			</div>
		  
<?php
require "footer.php";
?>
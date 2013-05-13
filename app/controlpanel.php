<?php

require_once "_config.php";

require "header.php";

?>


			<div class="row" ng-app="myApp">
				<div class="span12"  ng-controller="MainCtrl">
					<h3>Control Panel</h3>

						<ul class="thumbnails" >
						    <li class="span1" ng-repeat="era in eras">
						    <a class="thumbnail" href="#/era/{{era.id}}" ><img src="img/{{era.img}}" alt=""  class="img-rounded"/></a>{{era.name}}
						    </li>
						</ul>
						<h3> {{eras[eraId-1].name}}</h3>
						<div>
						<select>
							<option>Theme...</option>
						</select>
						<select>
							<option>Place...</option>
						</select>
						<select>
							<option>Blah...</option>
						</select>
						</div>
						<div ng-view></div>

				</div>
			</div>
		  
<?php
require "footer.php";
?>
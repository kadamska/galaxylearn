<?php

require "lib/session.php";
require "lib/service.php";
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
						<div ng-controller="Era">
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
						<ul class="thumbnails">
						    <li class="span2" ng-repeat="story in stories">
						    <div class="thumbnail">
						    <img class="img-polaroid" src="http://images2.fanpop.com/image/photos/9400000/Aaaaaawwwwwwwwww-Sweet-puppies-9415255-1600-1200.jpg" >
						    <a href="#/story/{{story.id}}" >{{story.name}}</a><i class="icon-star"></i>
						    </div>
						    </li>
						</ul>

						</div>

				</div>
			</div>
		  
<?php
require "footer.php";
?>
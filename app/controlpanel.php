<?php
require_once "_config.php";
require "header.php";
?>
<div class="row" ng-app="myApp">
	<div class="span12">
		<hr class="skyblue-line">
		<ul id="pickera">
		    <li>
		        <a href="#/era/1/Ancient Era">
		            <img src="img/era/thumbnail/01-ancient.jpg">
    		        <span class="era-name ng-binding">Ancient Era</span>
		            <span class="era-times ng-binding">c. 3000 BCE-500 CE</span>
		        </a>
		    </li>
		    <li>
		        <a href="#/era/2/Medieval Era">
		            <img src="img/era/thumbnail/02-medieval.jpg">
    		        <span class="era-name ng-binding">Medieval Era</span>
		            <span class="era-times ng-binding">c. 500-1500</span>
		        </a>
		    </li>
		    <li>
		        <a href="#/era/3/Renaissance Era">
		            <img src="img/era/thumbnail/03-renaissance.jpg">
    		        <span class="era-name ng-binding">Renaissance Era</span>
		            <span class="era-times ng-binding">c. 1400-1500</span>
		        </a>
		    </li>
		    <li>
		        <a href="#/era/4/Age of Discovery">
		            <img src="img/era/thumbnail/04-discovery.jpg">
    		        <span class="era-name ng-binding">Age of Discovery</span>
		            <span class="era-times ng-binding">c. 1450-1650</span>
		        </a>
		    </li>
		    <li>
		        <a href="#/era/5/Age of Enlightenment">
		            <img src="img/era/thumbnail/05-enlightenment.jpg">
    		        <span class="era-name ng-binding">Age of Enlightenment</span>
		            <span class="era-times ng-binding">c. 1650-1800</span>
		        </a>
		    </li>
		    <li>
		        <a href="#/era/6/Industrial Revolution">
		            <img src="img/era/thumbnail/06-industrial.jpg">
    		        <span class="era-name ng-binding">Industrial Revolution</span>
		            <span class="era-times ng-binding">c. 1760-1900</span>
		        </a>
		    </li>
		    <li>
		        <a href="#/era/7/Machine Age">
		            <img src="img/era/thumbnail/07-machine.jpg">
    		        <span class="era-name ng-binding">Machine Age</span>
		            <span class="era-times ng-binding">c.1900-2000</span>
		        </a>
		    </li>
		</ul>
		<hr class="skyblue-line">
		<div class="era-loadview" ng-view></div>
	</div>
</div>
<?php
require "footer.php";

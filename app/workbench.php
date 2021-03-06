<?php 
require_once "_config.php";
restrict();

require "header.php";
?>
<?php
	if ($_SESSION['admin']) {
    // show admin options
    ?>			
    <div ng-app="wbApp2">
        <div class="row">
        	<div class="span12">
        		<h3>Ready for Review</h3>
        		<ul style="list-style-type:none;" ng-controller="AdminReviewCtrl">
        			<li class="span4" ng-repeat="story in stories">
        				<div class="thumbnail">
        				{{story.screen_name}}
        					<a href="controlpanel.php#/story/{{story._id.$oid}}" >{{story.title}}<img src="{{story.img}}" ></a><br/>
        					<a href="#/story/edit/{{story._id.$oid}}" class="btn btn-large btn-primary">Edit</a>
        					<a href="data.php?type=rejectStory&id={{story._id.$oid}}" class="btn btn-large btn-primary">Delete</a>
        				</div>
        			</li>
        			<li ng-show="!stories.length">No adventures ready for review.</li>
        		</ul>
        		<div class="clearfix"></div>
        		<hr>
        		<div class="row">
        			<div class="span12" ng-view></div>
        	  	</div>
        	</div>
        </div>
    </div>
<?php
	} else {
    // show non-admin options
?>
    <div ng-app="wbApp">
    	<div class="row">
    		<div class="span12">
    			<div  class="row">
    				<div class="span12" id="workbench-links">
    					<button class="btn btn-primary" onclick="window.location.href='#/drafts'">DRAFT</button>
    					<button class="btn btn-primary" onclick="window.location.href='#/submitted'">SUBMITTED</button>
    					<button class="btn btn-primary" onclick="window.location.href='#/story/create'">CREATE NEW</button>
    				</div>
    			</div>
    			<div class="row">										
    				<div class="span12" ng-view></div>		
    		  	</div>
    		</div>
        </div>
    </div>
<?php
	}
require "footer.php";

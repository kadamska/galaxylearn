'use strict';

/* Controllers */

function MainCtrl($scope, $http, $location) {
    $http.get('data.php?type=eras').success(function(data) {
        $scope.eras = data;
    });
}

function EraCtrl($scope, $routeParams, $http) {
    $http.get('data.php?type=stories&eraId='+ $routeParams.eraId).success(function(data) {
        //jQuery("html, body").animate({ scrollTop: jQuery('.era-loadview').offset().top }, 1000);
    	for (var i=0; i<data.length; i++) {
    		if (!data[i].img.length) {
    			data[i].img = 'img/workbenchimage.png';
    		}
    	}
        $scope.stories = data;
    });
}

function wbCtrl($scope, $http, $location) {
    // Controller
}

function StoryCtrl($scope, $routeParams, $http, $location) {

    var startSaving;
    var saveFlag = 0;

    jQuery('#workbench-links').css('display','block');
    $http.get('data.php?type=story&storyId='+ $routeParams.storyId).success(function(data) {

    	/*
        if(jQuery('.era-loadview').length){
            jQuery("html, body").animate({ scrollTop: jQuery('.era-loadview').offset().top }, 1000);
        }*/

    	/*
        if(jQuery('.editadventure').length){
            jQuery("html, body").animate({ scrollTop: jQuery('.editadventure').offset().top }, 1000);
        }        
        */
        if (!data.img.length) {
            data.img = 'img/workbenchimage.png';
        } else {
            if(!jQuery('#cropthisimg').length){
                jQuery('#image_crop').append('<img src="'+ data.img +'" id="cropthisimg" />');
            }
            /*
            if(!jQuery('#cropthisimg-preview').length){
                jQuery('.img-preview').append('<img src="'+ data.img +'" id="cropthisimg-preview" />');
            }
            */
        }

        //console.log('Era ID: '+ data.era_id);

        jQuery('input[name="era_id"]').val(data.era_id);

        if (data.status == "1"){
            jQuery('#submitbtn').hide();
        }
        
        //console.log(data);
        
        $scope.story = data;
    });

    

    $scope.era_name = $routeParams.eraName;
    /* $scope.submit_story=  function () {

        $http({
            url: 'data.php?type=newstory',
            method: "POST",
            data: {
                'era_id': $scope.story.era_id,
                'body': $scope.story.body,
                'title': $scope.story.title, 
                'img': $scope.story.img,
                'age': $scope.story.age, 
                'id': $scope.story._id.$oid},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your adventure has been saved. 1");
                window.location.href='workbench.php';
            }).error(function (response) {
                alert("There was a problem saving your adventure. Please try again later. 1");
        });
    } */

    $scope.submitForReview = function() {
        //console.log('submitted');
        $http({
            url: 'data.php?type=submitStory',
            method: "POST",
            data: {
                'era_id': jQuery('input[name="era_id"]').val(),
                'status': 1,
                'body': $scope.story.body,
                'title': $scope.story.title, 
                'img': $scope.story.img, 
                'age': $scope.story.age,
                'allages' : $scope.story.allages,
                'id': $scope.story._id.$oid},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your adventure has been submitted.");
                window.location.href='workbench.php';
            }).error(function (response) {
                alert("There was a problem submitting your adventure. Please try again later.");
            });
        }

    $http.get('data.php?type=authenticated').success(function(data) {
        if (data.admin == '1' && $scope.story.status == 1) {
            $scope.visible = "display:visible;";            
        }
        else {
            $scope.visible = "display:none;";
        }

        if (data.admin == '1'){
            jQuery('.deletebutton').show();
        }

        if ($scope.story) {
	        $scope.story.visible = "none";
	        if (data.user_id == $scope.story.user && $scope.story.status == 0) {
	            $scope.story.visible = "visible";
	        }
        }
    });

    $scope.approve = function(id) {
        //console.log(id + ' approved');
    }

    $scope.reject = function(id) {
        //console.log(id + ' rejected');
    }

    $scope.submit_story =  function () {
        clearInterval(startSaving);
        $http({
            url: 'data.php?type=newstory',
            method: "POST",
            data: {
                'era_id': jQuery('input[name="era_id"]').val(),
                'body': $scope.story.body,
                'img' : jQuery('form[name=StoryEdit] input[name=img]').val(),
                //'img': $scope.story.img, 
                'age': $scope.story.age,
                'allages' : $scope.story.allages,
                'title': $scope.story.title,
                'id': jQuery('form[name=StoryEdit] input[name=id]').val()
            },
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your adventure has been saved.");
                window.location.href='workbench.php';
            }).error(function (response) {
                alert("There was a problem saving your adventure. Please try again later.");
                alert(age);
            });
    };

    jQuery('#workbench-links button').click(function(){
        //console.log('canceling interval..');
        clearInterval(startSaving);
    });    

    /*
    // Upload Controller
    jQuery("#my-awesome-dropzone").dropzone({ 
        url: "uploads/",
        maxFilesize: 3        
    });    
      */  
}


function StoryNewCtrl ($scope, $routeParams, $http, $location) {
    jQuery('#workbench-links').css('display','block');
    var startSaving;
    var saveFlag = 0;

    $http.get('data.php?type=eras').success(function(data) {
            $scope.eras = data;
    });

    $scope.submitForReview = function() {
        $http({
            url: 'data.php?type=submitStory',
            method: "POST",
            data: {
                'era_id': jQuery('select[name="era_id"]').val(),
                'status': 1,
                'body': $scope.story.body,
                'title': $scope.story.title, 
                'img': jQuery('form[name=StoryEdit] input[name=img]').val(),
                'age': $scope.story.age,
                'allages' : $scope.story.allages,
                'id': jQuery('form[name=StoryEdit] input[name=id]').val()
            },
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your adventure has been submitted.");
                window.location.href='workbench.php';
            }).error(function (response) {
                alert("There was a problem submitting your adventure. Please try again later.");
            });
    }



    $scope.submit_story =  function () {
        clearInterval(startSaving);
        $http({
            url: 'data.php?type=newstory',
            method: "POST",
            data: {
                'era_id': jQuery('select[name="era_id"]').val(),
                'body': $scope.story.body,
                'img' : jQuery('form[name=StoryEdit] input[name=img]').val(),
                //'img': $scope.story.img, 
                'age': $scope.story.age,
                'allages' : $scope.story.allages,
                'title': $scope.story.title,
                'id': jQuery('form[name=StoryEdit] input[name=id]').val()
            },
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your adventure has been saved.");
                window.location.href='workbench.php';
            }).error(function (response) {
                alert("There was a problem saving your adventure. Please try again later.");
                alert(age);
            });
    };

    $scope.autosave_submit_story =  function () {
        //console.log('sending this: '+ jQuery('form[name=StoryEdit] input[name=id]').val() );
        $http({
            url: 'data.php?type=newstory',
            method: "POST",
            data: {
                'era_id': jQuery('select[name="era_id"]').val(),
                'body': $scope.story.body,
                'img' : jQuery('form[name=StoryEdit] input[name=img]').val(),
                //'img': $scope.story.img, 
                'age': $scope.story.age,
                'allages' : $scope.story.allages,
                'title': $scope.story.title,
                'id': jQuery('form[name=StoryEdit] input[name=id]').val()
            },
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                //console.log("Your story has been autosaved.");
                jQuery('form[name=StoryEdit] input[name=id]').val(response._id.$oid);
                //jQuery('form[name=StoryEdit] #previewButton').attr('href', '#/story/'+response._id.$oid).removeClass('disabled');
            }).error(function (response) {
                //console.log("There was a problem autosaving your adventure. Please try again later.");
            });
    };    

    saveFlag = 0;

    jQuery('form[name=StoryEdit] input, form[name=StoryEdit] textarea').keyup(function() {
      if(saveFlag==0){
            startSaving = setInterval($scope.autosave_submit_story, 10000);
            saveFlag = 1;
      }
    });

    jQuery('#workbench-links button').click(function(){
        //console.log('canceling interval..');
        clearInterval(startSaving);
    });    
/*
    // Upload Controller
    jQuery("#my-awesome-dropzone").dropzone({ 
        url: "uploads/",
        maxFilesize: 3        
    });
*/
}

function DraftsCtrl($scope, $routeParams, $http) {
    jQuery('#workbench-links').css('display','block');
    $http.get('data.php?type=user_stories_drafts').success(function(data) {
            $scope.stories = data;
    });
}

function SubmittedCtrl($scope, $routeParams, $http) {
    jQuery('#workbench-links').css('display','block');
    $http.get('data.php?type=user_stories_submitted').success(function(data) {
            $scope.stories = data;
    });
}

function AdminReviewCtrl($scope, $routeParams, $http, $location) {
    $http.get('data.php?type=submittedstories').success(function(data) {
            $scope.stories = data;
            //$location.hash(data);
			//$anchorScroll();
    });

}

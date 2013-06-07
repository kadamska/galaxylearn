'use strict';

/* Controllers */

function MainCtrl($scope, $http, $location) {
    $http.get('data.php?type=eras').success(function(data) {
            $scope.eras = data;
    });
}

function EraCtrl($scope, $routeParams, $http) {
    $http.get('data.php?type=stories&eraId='+ $routeParams.eraId).success(function(data) {
        if (data.img == null) {
            data.img = 'img/workbenchimage.png';
        }
        $scope.stories = data;
    });
}

function StoryCtrl($scope, $routeParams, $http, $location) {
    $http.get('data.php?type=story&storyId='+ $routeParams.storyId).success(function(data) {
        if (data.img == null) {
            data.img = 'img/workbenchimage.png';
        }
            $scope.story = data;
    });

    $scope.era_name = $routeParams.eraName;
    $scope.submit_story=  function () {

        $http({
            url: 'data.php?type=newstory',
            method: "POST",
            data: {
                'era_id': $scope.story.era_id,
                'body': $scope.story.body,
                'title': $scope.story.title, 
                'img': $scope.story.img, 
                'id': $scope.story._id.$oid},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your story has been saved.");
                window.location.href='workbench.php';
            }).error(function (response) {
                alert("There was a problem saving your story. Please try again later.");
        });
    }

    $scope.submitForReview = function() {
        console.log('submitted');
        $http({
            url: 'data.php?type=submitStory',
            method: "POST",
            data: {
                'era_id': $scope.story.era_id,
                'status': 1,
                'body': $scope.story.body,
                'title': $scope.story.title, 
                'img': $scope.story.img, 
                'id': $scope.story._id.$oid},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your story has been submitted.");
                $location.path('#/submitted').replace();
            }).error(function (response) {
                alert("There was a problem submitting your story. Please try again later.");
            });
        }

    $http.get('data.php?type=authenticated').success(function(data) {
        if (data.admin == '1') {
            $scope.visible = "display:visible;";
        }
        else {
            $scope.visible = "display:none;";
        }
        $scope.story.visible = "none";
        if (data.user_id == $scope.story.user && $scope.story.status == 0) {
            $scope.story.visible = "visible";
        }
    });

    $scope.approve = function(id) {
        console.log(id + ' approved');
    }

    $scope.reject = function(id) {
        console.log(id + ' rejected');
    }
}

function StoryNewCtrl ($scope, $routeParams, $http) {

    $http.get('data.php?type=eras').success(function(data) {
            $scope.eras = data;
    });
    $scope.submit_story=  function () {
        $http({
            url: 'data.php?type=newstory',
            method: "POST",
            data: {
                'era_id': $scope.era_id,
                'body': $scope.story.body,
                'img': $scope.story.img, 
                'title': $scope.story.title},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your story has been saved.");
                window.location.href='workbench.php';
            }).error(function (response) {
                alert("There was a problem saving your story. Please try again later.");
            });


    };
}

function DraftsCtrl($scope, $routeParams, $http) {
    $http.get('data.php?type=user_stories_drafts').success(function(data) {
            $scope.stories = data;
    });
}

function SubmittedCtrl($scope, $routeParams, $http) {
    $http.get('data.php?type=user_stories_submitted').success(function(data) {
            $scope.stories = data;
    });
}

function AdminReviewCtrl($scope, $routeParams, $http) {
    $http.get('data.php?type=submittedstories').success(function(data) {
            $scope.stories = data;
    });
}


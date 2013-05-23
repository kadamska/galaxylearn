'use strict';

/* Controllers */

function MainCtrl($scope, $http, $location) {
    $http.get('data.php?type=eras').success(function(data) {
            $scope.eras = data;
    });
}

function EraCtrl($scope, $routeParams, $http) {
    $http.get('data.php?type=stories&eraId='+ $routeParams.eraId).success(function(data) {
            $scope.stories = data;
    });
}

function StoryCtrl($scope, $routeParams, $http) {
    $http.get('data.php?type=story&storyId='+ $routeParams.storyId).success(function(data) {
            $scope.story = data;
    });
;
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
            }).error(function (response) {
                alert("There was a problem saving your story. Please try again later.");
            });


    };

    $http.get('data.php?type=authenticated').success(function(data) {
        if (data.admin == '1') {
            $scope.visible = "display:visible;";
        }
        else {
            $scope.visible = "display:none;";
        }
    });


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
                'era_id': $scope.story.era_id,
                'body': $scope.story.body,
                'img': $scope.story.img, 
                'title': $scope.story.title},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
                alert("Your story has been saved.");
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

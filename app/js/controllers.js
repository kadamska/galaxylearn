'use strict';

/* Controllers */

function MainCtrl($scope, $http, $location) {
    $http.get('data/eras.json').success(function(data) {
            $scope.eras = data;
    });
}

function Era($scope, $routeParams, $http) {
    $scope.eraId = $routeParams.eraId;
    $http.get('data/era'+ $routeParams.eraId +'.json').success(function(data) {
            $scope.stories = data;
    });
}

function Timeline($scope, $routeParams, $http) {
    $scope.eraId = $routeParams.eraId;
    $http.get('data/era'+ $routeParams.eraId +'.json').success(function(data) {
            $scope.stories = data;
    });
}

function Story($scope, $routeParams, $http) {
    $http.get('data/era'+ $routeParams.storyId +'.json').success(function(data) {
            $scope.story = data[0];
    });
    $scope.submit = function() {
        alert($scope.story.name);
    }
}
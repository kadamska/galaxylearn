'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', []).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/timeline', {templateUrl: 'partials/timeline.html', controller: Timeline}).
    when('/era/:eraId', {templateUrl: 'partials/era.html', controller: Era}).
    when('/story/:storyId', {templateUrl: 'partials/story.html', controller: Story}).
    otherwise({redirectTo: '/timeline'});
  }]);

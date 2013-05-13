'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', []).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/home', {templateUrl: 'partials/home.html'}).
    when('/era/:eraId', {templateUrl: 'partials/era.html', controller: EraCtrl}).
    when('/story/:storyId', {templateUrl: 'partials/story.html', controller: StoryCtrl}).
    when('/story/edit/:storyId', {templateUrl: 'partials/story-edit.html', controller: StoryCtrl}).
    otherwise({redirectTo: '/home'});
  }]);

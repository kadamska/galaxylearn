'use strict';


// Declare app level module which depends on filters, and services
var myapp = angular.module('myApp', []).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/home', {templateUrl: 'partials/home.html'}).
    when('/era/:eraId/:eraName', {templateUrl: 'partials/era.html', controller: EraCtrl}).
    when('/story/:storyId', {templateUrl: 'partials/story.html', controller: StoryCtrl}).
    otherwise({redirectTo: '/home'});
  }]);

// Declare app level module which depends on filters, and services
var wbapp = angular.module('wbApp', []).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/drafts', {templateUrl: 'partials/drafts.html', controller: DraftsCtrl}).
    when('/submitted', {templateUrl: 'partials/submitted.html', controller: SubmittedCtrl}).
    when('/story/create', {templateUrl: 'partials/story-new.html', controller: StoryNewCtrl}).
    when('/story/edit/:storyId', {templateUrl: 'partials/story-edit.html', controller: StoryCtrl}).
    when('/story/:storyId', {templateUrl: 'partials/story.html', controller: StoryCtrl}).
    otherwise({redirectTo: '/drafts'});
  }]);

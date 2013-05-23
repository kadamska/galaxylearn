'use strict';

/* Directives */
wbapp.directive('admin', function($compile) {
	return {
		restrict: 'E',
		replace: true,
		templateUrl: 'partials/admin.html'
	}
} );
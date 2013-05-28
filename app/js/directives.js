'use strict';

/* Directives */
wbapp.directive('admin', function() {
	return {
		restrict: 'E',
		replace: true,
		templateUrl: 'partials/admin.html',
		scope: {
			approve: '&'
		}
	}
});
(function(){
	var app = angular.module("directives",[]);

	app.directive("layoutSelecter", function(){
		return {
			restrict: "E",
			templateUrl: "app/views/layoutSelecter.html"
		};
	});

	app.directive("header", function(){
		return {
			restrict: "E",
			templateUrl: "app/views/layoutSelecter.html"
		};
	});

	app.directive('onFinishRender', function ($timeout) {
		return {
			restrict: 'A',
			link: function (scope, element, attr) {
				if (scope.$last === true) {
					$timeout(function () {
						scope.$emit('ngRepeatFinished');
					});
				}
			}
		};
	});
})();
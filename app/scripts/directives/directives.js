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
})();
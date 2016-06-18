(function(){
	var app = angular.module("ins.items.advanced", []);

	app.directive("showAdvanced",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/items/items-advanced.html",
		};
	});
})();
(function(){
	var app = angular.module("ins.header", []);

	app.directive("insHeader", function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/header/header.html",
			controller: HeaderController,
			controllerAs: "headerCtrl"
		};
	});

	function HeaderController( $scope, $route, $location ){
		var self = this;
		self.url = "http://localhost/10_InspirationCrawler/InspirationCrawler";
		$scope.$on('$routeChangeSuccess', function () {
			var urlFlagments = $location.$$path.split("/");
			self.currentPage = urlFlagments[1];
		});
	}
})();
(function(){
	var app = angular.module("MainApp", ["ngRoute","ngMaterial", "services", "controllers", "directives"]);

	app.config( function($routeProvider, $locationProvider){
		$routeProvider.
			when("/", {
				templateUrl: "app/views/whole.html",
				controller: "WholeViewController",
				controllerAs: "wholeCtrl"
			}).
			when("/detail/:projectNo/:branchNo",{
				templateUrl: "app/views/detail.html",
				controller: "DetailViewController",
				controllerAs: "detailCtrl"
			}).
			when("/detail/:projectNo",{
				templateUrl: "app/views/detail.html",
				controller: "DetailViewController",
				controllerAs: "detailCtrl"
			}).
			when("/relation",{
				templateUrl: "app/views/relation.html",
				controller: "RelationViewController",
				controllerAs: "relationCtrl"
			}).
			otherwise({
				redirectTo: "/"
			});
	});
})();
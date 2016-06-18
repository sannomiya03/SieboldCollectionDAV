(function(){
	var app = angular.module("ins.modal.directives", ["ins.modal.controllers"]);

	app.directive("insModalImage",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal-image.html",
		};
	});
	app.directive("insModalAdvanced",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal-advanced.html",
		};
	});
	app.directive("insModalTitle",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal-title.html",
		};
	});
	app.directive("insModalDescription",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal-description.html",
		};
	});
	app.directive("insModalCategories",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal-categories.html",
		};
	});
	app.directive("insModalAlbums",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal-albums.html",
		};
	});
	app.directive("insModalTags",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal-tags.html",
		};
	});
})();
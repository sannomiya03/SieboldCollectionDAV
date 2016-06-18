(function(){
	var app = angular.module("c.layoutController",[]);

	app.controller("LayoutController", function( LayoutState ){
		var self = this;
		self.LayoutState = LayoutState;
	});
})();
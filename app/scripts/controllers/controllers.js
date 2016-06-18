(function(){
	var app = angular.module("controllers",["c.wholeView", "c.detailView", "c.relationView","c.layoutController"]);

	app.controller("MainController", function( $scope, Items, ModalState ){
		var self = this;
		self.instansExist=false;
		self.Items = Items;

		$scope.$on('$viewContentLoaded', function(event) {
			if(!self.instansExist){
				console.log("Welcome to Siebold DAV");
				Items.updateItems();
				self.instansExist = true;
			}
		});
	});
})();
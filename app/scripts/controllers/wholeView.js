(function(){
	var app = angular.module("c.wholeView",[]);

	app.controller("WholeViewController", function( $scope, Items, Item, ModalState ){
		var self = this;
		self.Items = Items;
		self.Item = Item;

		$scope.$on('$viewContentLoaded', function(event){
			console.log("CULLENT VIEW MODE > Whole view");
		});
	});
})();
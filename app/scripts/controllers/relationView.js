(function(){
	var app = angular.module("c.relationView",[]);

	app.controller("RelationViewController", function( $scope, Items ){
		var self = this;
		self.Items = Items;

		$scope.$on('$viewContentLoaded', function(event) {
			console.log("CULLENT VIEW MODE > Relation view");
		});
	});
})();
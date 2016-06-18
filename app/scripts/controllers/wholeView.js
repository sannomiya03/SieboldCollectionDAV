(function(){
	var app = angular.module("c.wholeView",[]);

	app.controller("WholeViewController", function( $scope, Items, ModalState ){
		var self = this;
		self.Items = Items;
		self.calcX = calcX;
		self.calcY = calcY;

		$scope.$on('$viewContentLoaded', function(event){
			console.log("CULLENT VIEW MODE > Whole view");
		});

		function calcX( index ){
			return Math.floor(index/5)*100;
		}

		function calcY( index ){
			//console.log(index+","+index%5);
			return index%5*100;
		}
	});
})();
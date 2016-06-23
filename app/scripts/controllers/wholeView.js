(function(){
	var app = angular.module("c.wholeView",[]);

	app.controller("WholeViewController", function( $scope, $location, Items, Item, ModalState ){
		$scope.$on('$viewContentLoaded', function(event){
			console.log("CULLENT VIEW MODE > Whole view, detailMode "+Item.detailMode );
			if( Item.detailMode ){
				$("#dyItem1").animate({
					width: 100,
					height: 100,
					top: 100,
					left: 100
				}, 300);
			}
		});
		var self = this;
		self.Items = Items;
		self.Item = Item;
		self.toDetail = toDetail;

		function toDetail( item ){
			console.log( "To Detail Page: S"+item.s_no+"/"+item.branch_no );
			Item.tracePos( item, $("#dyItem1") );
			Item.detailMode = true;
			$("#dyItem1").animate({
				width: $(window).width()/3,
				height: $(window).width()/3,
				top: 100,
				left: 100
			},{
				duration: 300,
				complete: function(){
					$scope.$apply(function(){$location.path("detail/S"+item.s_no+"/"+item.branch_no);});
				}
			});
		}
	});
})();
(function(){
	var app = angular.module("c.detailView",[]);

	app.controller("DetailViewController", function( $scope, $location, $rootScope, $routeParams, $http, Items, Item, Position ){
		var self = this;
		self.Items = Items;
		self.Item = Item;
		self.back = back;

		$scope.$on('$viewContentLoaded', function(event) {
			var sid = $routeParams.projectNo.replace("S","");
			var bid = $routeParams.branchNo;
			var query = { sid: sid, bid: bid };
			console.log("CULLENT VIEW MODE > Detail view. id:"+sid+", branchNo:"+bid);
			$http({
				method: 'GET',
				url: './server/api/getTheItemInfo.php',
				params: query
			}).success(function(data){
				console.log("GET > get item info, sid:"+sid+", bid:"+bid);
				Item.selectedItem = data;
				Item.selectedItemPos = Position.getPos( Items.getIndex(Items.items,Item.selectedItem) );
				//ロード時Items.itemsが空になっているバグあり
			});
			if( Items.navItems.length == 0 ){
				Items.loadNavItems();
			}
		});

		function back(){
			var index = Items.getIndex( Items.items, Item.selectedItem );
			if( Item.detailMode ){
				$("#dyItem1").fadeIn(0);
				$("#dyItem1").animate({
					width: 100,
					height: 100,
					left: Position.getPos(index).x + 10,
					top: Position.getPos(index).y + $(window).height()*0.1 + 10
				}, 300);
			}
			setTimeout(function(){
				$scope.$apply(function(){ $location.path(""); });
			}, 100 );
		}
	});
})();
(function(){
	var app = angular.module("c.detailView",[]);

	app.controller("DetailViewController", function( $scope, $location, $rootScope, $routeParams, $http, Items, Item ){
		var self = this;
		self.item = {};
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
				self.item = data;
			});
			if( Items.navItems.length == 0 ){
				Items.loadNavItems();
			}
		});

		function back(){
			var index = getItemIndex( Items.items, self.item );
			console.log( index );
			if( Item.detailMode ){
				$("#dyItem1").animate({
					width: 100,
					height: 100,
					top: Item.targets.y,
					left: Item.targets.x
				}, 300);
			}
			setTimeout(function(){
				$scope.$apply(function(){ $location.path(""); });
			}, 100 );
		}

		function getItemIndex( items, item ){
			for( var i=0; i<items.length; i++ ){
				if( items[i].id == item.id ){
					return i;
				}
			}
			return -1;
		}
	});
})();
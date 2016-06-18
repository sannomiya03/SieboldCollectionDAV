(function(){
	var app = angular.module("c.detailView",[]);

	app.controller("DetailViewController", function( $scope, $rootScope, $routeParams, $http, Items ){
		var self = this;
		self.item = {};
		self.Items = Items;

		$scope.$on('$viewContentLoaded', function(event) {
			var sid = $routeParams.projectNo.replace("S","");
			var bid = $routeParams.branchNo;
			var query = { sid: sid, bid: bid };
			console.log("CULLENT VIEW MODE > Detail view. id:"+sid+", branchNo:"+bid);
			console.log(query);
			$http({
				method: 'GET',
				url: './server/api/getTheItemInfo.php',
				params: query
			}).success(function(data){
				console.log("GET > get item info, sid:"+sid+", bid:"+bid);
				console.log(data);
				self.item = data;
			});
			if( Items.navItems.length==0 ){
				Items.loadNavItems();
			}
		});
	});
})();
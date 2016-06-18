(function(){
	var services = angular.module("s.items",[]);

	services.service("Items", function( $http, $httpParamSerializerJQLike ){
		var self = this;
		self.itemSize = 0;
		self.items = [];
		self.navItems = [];
		self.init = init;
		self.loaderActive = true;
		self.loading = false;

		self.queryData = {
			page: 0,
			taxonomy: "",
			val: ""
		};

		function init(){
			self.items = [];
			self.itemSize = 0;
			self.page = 0;
			self.loaderActive = true;
			self.loading = false;
		}

		self.updateItems = function(){
			self.loading = true;
			self.queryData.page = 0;
			self.itemSize = 0;
			console.log( self.queryData );
			$http({
				method: 'POST',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8' },
				transformRequest: $httpParamSerializerJQLike,
				url: './server/api/getTheItems.php',
				data: self.queryData,
			}).success(function(data){
				console.log("GET > get items, "+data.size+" Results.");
				console.log(data);
				self.itemSize = data.size;
				self.items = data.items;
				self.loading = false;
			});
		};

		self.loadPage = function( callback ){
			if( self.items.length===0 ) return;
			if( self.loading ) return;
			self.loading = true;
			self.queryData.page++;
			console.log(self.queryData);
			$http({
				method: 'POST',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8' },
				transformRequest: $httpParamSerializerJQLike,
				url: './server/api/getTheItems.php',
				data: self.queryData,
			}).success(function(data){
				console.log("GET > loading items, "+data.length+" added.");
				for(var i=0;i<data.items.length; i++){
					self.items.push(data.items[i]);
				}
				self.loading = false;
			});
		};

		self.loadNavItems = function(){
			$http({
				method: 'GET',
				url: './server/api/getTheItems.php',
			}).success(function(data){
				self.navItems = data.items;
				console.log("GET > nav items");
			});
		}
	});
})();
(function(){
	var app = angular.module("ins.items", ["ngAnimate","ins.items.advanced"]);

	app.directive("insItems",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/items/items.html",
			controller: ItemController,
			controllerAs: "itemCtrl"
		};
	});
	app.directive('whenScrolled', function($window){
		return {
			require: "^insItems",
			link: function( scope, elem, attr, ItemController ){
				var raw = elem[0];
				angular.element($window).bind('scroll', function(){
					if(raw.offsetTop < this.pageYOffset+window.innerHeight){
						if( !ItemController.loading ){
							ItemController.loadItems();
						}
					}
				});
			}
		};
	});

	function ItemController( $scope, $http, $window, ItemState, ModalState ){
		$scope.$on('$viewContentLoaded', function(event) {
			self.init();
		});

		var self = this;
		self.ItemState = ItemState;
		self.ModalState = ModalState;
		self.loading = false;
		self.loadItems = loadItems;
		self.getItems = function(){ return self.ItemState.items; };
		self.openModal = ModalState.openModal;
		self.search = search;

		function init(){
			self.loading = false;
		}

		function loadItems(){
			if( self.loading ) return;
			if( !ItemState.useLoad ) return;
			self.loading = true;
			self.ItemState.loadPage();
			self.loading = false;
		}

		function search( keyword, select ){
			console.log(keyword+","+select);
			$('html,body').animate({ scrollTop: 0 }, 'ease');
			ItemState.input_val = keyword;
			ItemState.select = select;
			ItemState.updateItems();
		}

	}
})();
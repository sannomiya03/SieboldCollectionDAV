(function(){
	var app = angular.module("ins.input", ["ins.input.colors","ins.input.contents","ins.input.services"]);

	app.directive("insSearch", function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/input/input.html",
			controller: SearchController,
			controllerAs: "searchCtrl"
		};
	});

	function SearchController( ItemState, $http, $scope ){
		var self = this;
		self.ItemState = ItemState;
		self.input_val = self.ItemState.input_val;
		self.select = self.ItemState.select;
		self.isOpenedAdvanced = false;
		self.openAdvanced = openAdvanced;
		self.keydown = keydown;
		self.keypress = keypress;
		self.states = [];
		self.activeState = "";
		self.activeStates = getMatchedStates();
		self.showPlaceholder = showPlaceholder;
		loadStates();
		self.targets = [
			"指定なし",
			"資料種別",
			"技法",
			"文様"
		];

		function openAdvanced(){
			self.isOpenedAdvanced = !self.isOpenedAdvanced;
		}

		function keypress(){
			console.log("KEY PRESSED");
			self.ItemState.updateItems();
			$("#seachiForm").blur();
		}

		function keydown(e){
			self.activeStates = getMatchedStates();
			if(e.which == 9 || e.keyCode == 9){
				if(self.activeStates.length>0){
					self.input_val = self.activeStates[0];
					self.ItemState.input_val = self.activeStates[0];
					console.log( self.ItemState.input_val );
				}
			}
		}

		function loadStates(){

		}

		function getMatchedStates(){
			if( self.ItemState.input_val.length === 0 ){
				self.activeState = "";
				return self.states;
			}
			var activeStates = [];
			for( var i=0; i<self.states.length; i++ ){
				for( var c=0; c<self.ItemState.input_val.length; c++ ){
					if( self.states[i].charAt(c) != self.ItemState.input_val.charAt(c) ) break;
					if( c == self.ItemState.input_val.length-1 ){
						//console.log("matched:"+self.states[i]);
						activeStates.push(self.states[i]);
					}
				}
			}
			if(activeStates.length>0) self.activeState = activeStates[0];
			else self.activeState="";
			return activeStates;
		}

		function showPlaceholder(){
			var active_element = document.activeElement;
			return ($(active_element).attr("id")=="seachiForm" && ItemState.input_val!='');
		}
	}
})();
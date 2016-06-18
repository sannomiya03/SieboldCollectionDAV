(function(){
	var app = angular.module("ins.input.colors", []);

	app.directive("insInputColors", function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/input/input-colors.html",
			controller: ColorController,
			controllerAs: "colorCtrl"
		};
	});

	function ColorController( ItemState, SelecterFunctions ){
		var self = this;
		self.colorSelecters = loadColorSelecters();
		self.changeSelecterActivity = changeSelecterActivity;

		function loadColorSelecters(){
			var colorSelecters = [
				{ name: "pink", isSelected: false },
				{ name: "red", isSelected: false },
				{ name: "orange", isSelected: false },
				{ name: "yellow", isSelected: false },
				{ name: "lime", isSelected: false },
				{ name: "green", isSelected: false },
				{ name: "cyan", isSelected: false },
				{ name: "blue", isSelected: false },
				{ name: "purple", isSelected: false },
				{ name: "black", isSelected: false },
				{ name: "white", isSelected: false }, ];
			return colorSelecters;
		}

		function changeSelecterActivity( selecter ){
			SelecterFunctions.changeSelecterActivity( selecter );
			ItemState.selected_colors = SelecterFunctions.getActiveSelecters( self.colorSelecters );
		}
	}
})();
(function(){
	var app = angular.module("ins.input.contents", []);

	app.directive("insInputContents", function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/input/input-contents.html",
			controller: ContentController,
			controllerAs: "contentCtrl"
		};
	});

	function ContentController( ItemState, SelecterFunctions ){
		var self = this;
		self.contentSelecters = loadContentSelecters();
		self.changeSelecterActivity = changeSelecterActivity;

		function loadContentSelecters(){
			var contentSelecters = [
				{ name: "WEB Images", isSelected: true },
				{ name: "Uploaded Images", isSelected: true }];
			return contentSelecters;
		}

		function changeSelecterActivity( selecter ){
			SelecterFunctions.changeSelecterActivity( selecter );
			ItemState.queryData.use_web_images = self.contentSelecters[0].isSelected;
			ItemState.queryData.use_local_images = self.contentSelecters[1].isSelected;
		}
	}
})();
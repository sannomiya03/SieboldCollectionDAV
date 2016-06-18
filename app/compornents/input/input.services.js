(function(){
	var services = angular.module("ins.input.services", []);

	services.service("SelecterFunctions", function(){
		var self = this;
		self.getActiveSelecters = function( selecters ){
			var activeSelecters = [];
			for( var i=0; i<selecters.length; i++ ){
				if(selecters[i].isSelected) activeSelecters.push(selecters[i].name);
			}
			return activeSelecters;
		};
		self.changeSelecterActivity = function( selecter ){
			selecter.isSelected = !selecter.isSelected;
		};
	});
})();
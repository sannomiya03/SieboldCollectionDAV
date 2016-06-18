(function(){
	var services = angular.module("s.layoutState",[]);

	services.service("LayoutState", function(){
		var self = this;
		self.states = [
			{ label:"展示順にみる", active: true },
			{ label:"時系列にみる", active: false },
			{ label:"地域別にみる", active: false }
		];
		self.init = init;
		self.changeLayout = changeLayout;

		function init(){
			self.states[0].active = false;
			self.states[1].active = false;
			self.states[2].active = false;
		}

		function changeLayout( state ){
			for( var i=0; i<self.states.length; i++ ){
				if( self.states[i].label == state.label ){
					self.states[i].active = true;
				}else{
					self.states[i].active = false;
				}
			}
		}
	});
})();
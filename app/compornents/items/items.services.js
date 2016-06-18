(function(){
	var services = angular.module("ins.items.services", []);

	services.service("AdvancedOption", function(){
		var self = this;
		self.sort_state = "ASCENDING";
		self.sort_status = ('ASCENDING DOWM').split(' ').map(function (state) { return { abbrev: state }; });
		self.layout_state = "thubmnail";
	});
})();
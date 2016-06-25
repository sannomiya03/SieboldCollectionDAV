(function(){
	var services = angular.module("s.item",[]);

	services.service("Item", function($location){
		var self = this;
		self.detailMode = false;
		self.selectedItem = {};
		self.getImageURL = getImageURL;
		self.getItemElm = getItemElm;

		function getImageURL( item, size ){
			if( item.branch_no === "" ){
				return "./../images/"+size+"/SMV-S"+item.s_no+"/0.jpg";
			}else{
				return "./../images/"+size+"/SMV-S"+item.s_no+"_"+item.branch_no+"/0.jpg";
			}
		}

		function getItemElm( item ){
			return $("#"+item.id);
		}
	});
})();
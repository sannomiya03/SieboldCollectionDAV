(function(){
	var services = angular.module("s.item",[]);

	services.service("Item", function(){
		var self = this;
		self.getImageURL = getImageURL;

		function getImageURL( item, size ){
			if( item.branch_no === "" ){
				return "./../images/"+size+"/SMV-S"+item.s_no+"/0.jpg";
			}else{
				console.log(item.s_no+"_"+item.branch_no);
				return "./../images/"+size+"/SMV-S"+item.s_no+"_"+item.branch_no+"/0.jpg";
			}
		}
	});
})();
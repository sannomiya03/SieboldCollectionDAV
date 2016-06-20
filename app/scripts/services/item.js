(function(){
	var services = angular.module("s.item",[]);

	services.service("Item", function(){
		var self = this;
		self.tracePos = tracePos;
		self.getImageURL = getImageURL;
		self.calcX = calcX;
		self.calcY = calcY;

		function tracePos( item, elm ){
			var itemElm = $("#"+item.id);
			console.log(itemElm);
			console.log(elm);
			elm.css({
				width: $(itemElm).width(),
				height: $(itemElm).height(),
				left: $(itemElm).offset().left,
				top: $(itemElm).offset().top
			});
		}

		function getImageURL( item, size ){
			if( item.branch_no === "" ){
				return "./../images/"+size+"/SMV-S"+item.s_no+"/0.jpg";
			}else{
				return "./../images/"+size+"/SMV-S"+item.s_no+"_"+item.branch_no+"/0.jpg";
			}
		}

		function calcX( index ){
			return Math.floor(index/5)*100;
		}
		function calcY( index ){
			return index%5*100;
		}
	});
})();
(function(){
	var services = angular.module("s.item",[]);

	services.service("Item", function($location){
		var self = this;
		self.detailMode = false;
		self.tracePos = tracePos;
		self.toDetailAnimation = toDetailAnimation;
		self.getImageURL = getImageURL;
		self.calcX = calcX;
		self.calcY = calcY;

		function tracePos( item, elm ){
			var itemElm = $("#"+item.id);
			elm.css({
				width: $(itemElm).width(),
				height: $(itemElm).height(),
				left: $(itemElm).offset().left,
				top: $(itemElm).offset().top
			});
		}

		function toDetailAnimation( item, elm, func ){
			self.detailMode = true;
			console.log(self.detailMode);
			$(elm).animate({
				width: $(window).width()/3,
				height: $(window).width()/3,
				top: 100,
				left: 100
			},300);
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
(function(){
	var services = angular.module("s.position",[]);

	services.service("Position", function(Items,Item){
		var self = this;
		self.getPos = getPos;
		self.getVisiblity = getVisiblity;
		self.tracePos = tracePos;
		self.calcExplodedPos = calcExplodedPos;

		function getPos( index ){
			var pos = {
				x: Math.floor(index/5) * 100,
				y: index % 5 * 100
			};
			var view = { x: pos.x, y: pos.y };
			return {
				x: pos.x,
				y: pos.y,
				view_x: view.x,
				view_y: view.y
			};
		}

		function getVisiblity( x ){
			if( x < $(window).width() ) return true;
			return false;
		}

		function tracePos( item, elm ){
			var itemElm = $("#"+item.id);
			elm.css({
				width: $(itemElm).width(),
				height: $(itemElm).height(),
				left: $(itemElm).offset().left,
				top: $(itemElm).offset().top
			});
		}

		function calcExplodedPos( p1, p2 ){
			var a = p2.y-p1.y,
				b = p2.x-p1.x,
				c = Math.sqrt(a*a+b*b);
			var sin_theta = a/c, cos_theta = b/c;
			return {
				x: p1.x+cos_theta*$(window).width()/2,
				y: p1.y+sin_theta*$(window).width()/2
			};
		}
	});
})();
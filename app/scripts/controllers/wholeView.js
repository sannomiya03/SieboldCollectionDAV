(function(){
	var app = angular.module("c.wholeView",[]);

	app.controller("WholeViewController", function( $scope, $location, Items, Item, Position ){
		$scope.$on('$viewContentLoaded', function(event){
			console.log("CULLENT VIEW MODE > Whole view, detailMode "+Item.detailMode );
		});
		$scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
			var items = $("#items").children(".visible");
			if( Item.detailMode ){
				gather( Item.selectedItem );
				Item.detailMode = false;
			}
		});
		var self = this;
		self.Items = Items;
		self.Item = Item;
		self.Position = Position;
		self.toDetail = toDetail;

		function toDetail( item ){
			console.log( "To Detail Page: S"+item.s_no+"/"+item.branch_no );
			Position.tracePos( item, $("#dyItem1") );
			Item.detailMode = true;
			$("#"+item.id).css("opacity",0);
			explode( item );
			moveToTile( item );
		}

		function explode( item ){
			var items = $("#items").children(".visible");
			var p1 = { x: $("#"+item.id).offset().left, y: $("#"+item.id).offset().top };
			for( var i=0; i<items.length; i++ ){
				var itemElm =  $("#"+items[i].id);
				var p2 = { x: $(itemElm).offset().left, y: $(itemElm).offset().top };
				var explodedPos = Position.calcExplodedPos( p1, p2 );
				$(itemElm).animate({
					left: explodedPos.x - 10,
					top:  explodedPos.y - 100,
					"opacity": 0
				},{
					duration:300,
					easing:"swing"
				});
			}
		}

		function gather( item ){
			var items = $("#items").children(".visible");
			var index = Items.getIndex(Items.items,item);
			var p1 = { x: Position.getPos(index).x, y: Position.getPos(index).y };
			for( var i=0; i<items.length; i++ ){
				var itemElm =  $("#"+items[i].id);
				var p2 = { x: $(itemElm).offset().left, y: $(itemElm).offset().top };
				var explodedPos = Position.calcExplodedPos( p1, p2 );
				$(itemElm).css({
					left: explodedPos.x - 10,
					top:  explodedPos.y - 100,
					"opacity": 0
				});
				$(itemElm).animate({
					left: p2.x-10,
					top:  p2.y-100+10,
					"opacity": 1
				},{
					duration:300,
					easing:"swing"
				});
			}
			setTimeout(function(){
				$("#dyItem1").fadeOut(250);
			}, 300);
		}

		function moveToTile( item ){
			$("#dyItem1").fadeIn(0);
			$("#dyItem1").find("img").attr("src",Item.getImageURL(item,800));
			$("#dyItem1").animate({
				width: $(window).width()*0.4-10,
				height: $(window).width()*0.4-10,
				top: $(window).height()*0.1+10,
				left: $(window).width()*0.1+10-1
			},{
				duration: 300,
				complete: function(){
					$scope.$apply(function(){$location.path("detail/S"+item.s_no+"/"+item.branch_no);});
				}
			});
		}
	});
})();
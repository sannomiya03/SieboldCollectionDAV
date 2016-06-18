(function(){
	var services = angular.module("ins.modal.services.animation", []);

	services.service("Animation", function(){
		var self = this;
		self.modalClosePos = {};
		self.modalOpenPos = {};
		self.moveToLeft = moveToLeft;
		self.moveToRight = moveToRight;
		self.moveToOpen = moveToOpen;
		self.moveToClose = moveToClose;
		self.setModalClosePos = setModalClosePos;
		self.setModalOpenPos = setModalOpenPos;
		self.setBGLayerSize = setBGLayerSize;

		function moveToLeft( prev_modal, next_modal ){
			self.setModalOpenPos();
			$(next_modal).fadeIn(0);
			$(next_modal).css({
				top: self.modalOpenPos.y,
				left: self.modalOpenPos.x - $(window).width(),
				width: self.modalOpenPos.w,
				height: self.modalOpenPos.h,
			}, 250);
			$(next_modal).animate({
				top: self.modalOpenPos.y,
				left: self.modalOpenPos.x,
				width: self.modalOpenPos.w,
				height: self.modalOpenPos.h,
			}, 250);
			$(prev_modal).animate({
				top: self.modalOpenPos.y,
				left: self.modalOpenPos.x + $(window).width(),
				width: self.modalOpenPos.w,
				height: self.modalOpenPos.h,
			}, 250 );
		}
		function moveToRight( prev_modal, next_modal ){
			self.setModalOpenPos();
			$(next_modal).fadeIn(0);
			$(next_modal).css({
				top: self.modalOpenPos.y,
				left: self.modalOpenPos.x + $(window).width(),
				width: self.modalOpenPos.w,
				height: self.modalOpenPos.h,
			}, 250);
			$(next_modal).animate({
				top: self.modalOpenPos.y,
				left: self.modalOpenPos.x,
				width: self.modalOpenPos.w,
				height: self.modalOpenPos.h,
			}, 250);
			$(prev_modal).animate({
				top: self.modalOpenPos.y,
				left: self.modalOpenPos.x - $(window).width(),
				width: self.modalOpenPos.w,
				height: self.modalOpenPos.h,
			}, 250 );
		}
		function moveToOpen( srcElm, targetModal ){
			self.setBGLayerSize();
			self.setModalClosePos( srcElm );
			$("#modal-background").fadeIn(250);
			$(targetModal).fadeIn(0);
			$(targetModal).css({
				top: self.modalClosePos.y,
				left: self.modalClosePos.x,
				width: self.modalClosePos.w,
				height: self.modalClosePos.h
			});
			self.setModalOpenPos();
			$(targetModal).animate({
				top: self.modalOpenPos.y,
				left: self.modalOpenPos.x,
				width: self.modalOpenPos.w,
				height: self.modalOpenPos.h,
			},{
				duration: 250,
			});
		}
		function moveToClose( targetElm, targetModal, callback ){
			self.setModalClosePos( targetElm );
			$(targetModal).animate({
				top: self.modalClosePos.y,
				left: self.modalClosePos.x,
				width: self.modalClosePos.w,
				height: self.modalClosePos.h,
			},{
				duration: 250,
				complete: callback
			});
		}
		function setModalClosePos( itemElm ){
			if( itemElm != undefined && itemElm.length != 0 ){
				self.modalClosePos = {
					x: $(itemElm).offset().left,
					y: $(itemElm).offset().top-window.pageYOffset,
					w: $(itemElm).width(),
					h: $(itemElm).height()
				};
			}else{
				self.modalClosePos = {
					x: $(window).width()/2,
					y: $(window).height()/2,
					w: 0,
					h: 0
				};
			}
		}
		function setModalOpenPos(){
			self.modalOpenPos = {
				x: $(window).width()*0.05,
				y: $(window).height()*0.05,
				w: $(window).width()*0.9,
				h: $(window).height()*0.9
			};
		}
		function setBGLayerSize(){
			$("#modal-background").css({
				width: $(window).width(),
				height: $(window).height()
			});
			$("#pager-prev").css({
				height: $(window).height()*0.9,
			});
			$("#pager-next").css({
				height: $(window).height()*0.9,
			});
		}
	});
})();
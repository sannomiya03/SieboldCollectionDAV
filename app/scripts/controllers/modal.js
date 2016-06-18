(function(){
	var app = angular.module("ins.modal", ["ngAnimate","ins.modal.services","ins.modal.directives","ins.modal.controllers"]);
	app.directive("insModal",function(){
		return {
			restrict: "E",
			templateUrl: "app/compornents/modal/modal.html",
			controller: ModalController,
			controllerAs: "modalCtrl"
		};
	});

	function ModalController( ItemState, ModalState, Terms, $scope, $compile, $http, $httpParamSerializerJQLike, Animation ){
		var self = this;
		self.ItemState = ItemState;
		self.ModalState = ModalState;
		self.editting = false;
		self.getModals = function(){ return self.ModalState.modals; };
		self.getShowModal = function(){ return self.ModalState.showModal; };
		self.getModalAnimate = function(){ return self.ModalState.modalAnimate; };
		self.existModal = function(){ return self.ModalState.modals.length > 0; };
		self.changeEditMode = function(){ self.editting = !self.editting; };
		self.chipSelect = chipSelect;
		self.addTerm = addTerm;
		self.removeTerm = removeTerm;
		self.deleteItem = deleteItem;
		self.favorite = favorite;
		self.closeModal = closeModal;
		self.addModal_toRight = addModal_toRight;
		self.addModal_toLeft = addModal_toLeft;
		self.existPrevItem = existPrevItem;
		self.existNextItem = existNextItem;

		function chipSelect( type, chip ){
			if( self.editting ) return;
			self.closeModal();
			if( chip.name==undefined || chip.name==null || chip.name=="" ) self.ItemState.inputChip( type, chip );
			else self.ItemState.inputChip( type, chip.name );
		}
		function addTerm( type, chip, item ){ updateTerms( type, item ); }
		function removeTerm( type, chip, item){ updateTerms( type, item ); }
		function deleteItem( item ){
			$http({
				method: 'POST',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8' },
				transformRequest: $httpParamSerializerJQLike,
				url: './server/api/deleatTheItem.php',
				data: { id:item.id, resource:item.resource }
			}).success(function(data){
				var index = 0;
				for(var i=0;i<ItemState.items.length;i++){
					if(ItemState.items[i].id==item.id) index = i;
				}
				ItemState.items.splice(index,index);
				self.closeModal();
			});
		}

		function updateTerms( type, item ){
			var queryData = {
				id: item.id,
				type: type,
				resource: item.resource,
				vals: []
			};
			switch( type ){
				case "Category": queryData.vals=item.categories; break;
				case "Album": queryData.vals=item.albums; break;
				case "Tag": queryData.vals=item.tags; break;
			}
			var onlyNameVals = [];
			for(var i=0;i<queryData.vals.length;i++){
				var val = queryData.vals[i];
				if( val.name==null || val.name==undefined || val.name=="" ) onlyNameVals.push(val);
				else onlyNameVals.push(val.name);
			}
			queryData.vals = onlyNameVals;
			$http({
				method: 'POST',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8' },
				transformRequest: $httpParamSerializerJQLike,
				url: './server/api/updateTerms.php',
				data: queryData
			});
		}

		function favorite(item){
			item.favorite = !item.favorite;
		}
		function closeModal(){
			self.ModalState.showModal = false;
			self.ModalState.modalAnimate = "close";
		}
		function addModal_toRight(){
			if( self.ModalState.modals.length > 1 ){ self.ModalState.modals.shift(); }
			addNextItem();
			setTimeout(function(){
				var old_elm = $("#modals").children(".item-modal")[0];
				var new_elm = $("#modals").children(".item-modal")[1];
				Animation.moveToRight( old_elm, new_elm );
			}, 1);
			function addNextItem(){
				var current_item = self.ModalState.modals[self.ModalState.modals.length-1].item;
				for( var i=0; i<self.ItemState.items.length-1; i++ ){
					if( self.ItemState.items[i].id == current_item.id ){
						self.ModalState.addModal( self.ItemState.items[i+1] );
						break;
					}
				}
			}
		}

		function addModal_toLeft(){
			if( self.ModalState.modals.length > 1 ){ self.ModalState.modals.shift(); }
			addPrevItem();
			setTimeout(function(){
				var old_elm = $("#modals").children(".item-modal")[0];
				var new_elm = $("#modals").children(".item-modal")[1];
				Animation.moveToLeft( old_elm, new_elm );
			}, 1);

			function addPrevItem(){
				var current_item = self.ModalState.modals[self.ModalState.modals.length-1].item;
				for( var i=1; i<self.ItemState.items.length; i++ ){
					if( self.ItemState.items[i].id == current_item.id ){
						self.ModalState.addModal( self.ItemState.items[i-1] );
						break;
					}
				}
			}
		}

		function existPrevItem(){
			if( self.ModalState.modals.length === 0 ) return false;
			var list = $("#item-list").children(".item");
			if( $(list[0]).attr("id") == self.ModalState.modals[self.ModalState.modals.length-1].item.id ) return false;
			else return true;
		}
		function existNextItem(){
			if( self.ModalState.modals.length === 0 ) return false;
			var list = $("#item-list").children(".item");
			if( $(list[list.length-1]).attr("id") == self.ModalState.modals[self.ModalState.modals.length-1].item.id ) return false;
			else return true;
		}
	}

	app.animation(".modalOpen", function( ModalState, Animation ){
		return {
			beforeAddClass: function(element, className, done){
				console.log("MODAL > open");
				var srcElm = $("#"+ModalState.modals[ModalState.modals.length-1].item.id);
				var targetModal = $(element).children(".item-modal");
				Animation.moveToOpen( srcElm, targetModal );
			},
		};
	});

	app.animation(".modalClose", function( ModalState, Animation ){
		return {
			beforeAddClass: function(element, className, done){
				console.log("MODAL > close");
				var targetElm = $("#"+ModalState.modals[ModalState.modals.length-1].item.id );
				var targetModal = $(element).children(".item-modal");
				var callback = function(){
					$(targetModal).fadeOut(0);
					ModalState.modals.length = 0;
					$("#modal-background").fadeOut(250);
				};
				console.log(targetElm);
				Animation.moveToClose( targetElm, targetModal, callback );
			}
		};
	});
})();
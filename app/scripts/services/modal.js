(function(){
	var services = angular.module("s.modal",[]);

	services.service("ModalState",function( $http, $httpParamSerializerJQLike ){
		var self = this;
		self.showModal = false;
		self.modals = [];
		self.modalAnimate = "";
		self.openModal = openModal;
		self.addModal = addModal;
		self.init = init;

		function init(){
			self.showModal = false;
			self.modals = [];
			self.modalAnimate = "";
		}

		function openModal(item){
			self.showModal = true;
			self.addModal(item);
			self.modalAnimate = "open";
		}

		function addModal( item ){
			self.modals.push({item:item});
			$http({
				method: 'POST',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8' },
				transformRequest: $httpParamSerializerJQLike,
				url: './server/api/getTheItemInfo.php',
				data: { id: item.id, resource: item.resource },
			}).success(function(data){
				console.log("GET > item detail info, docID:"+item.id);
				console.log(data);
			});
		}
	});
})();
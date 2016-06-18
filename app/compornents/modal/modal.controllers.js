(function(){
	var app = angular.module("ins.modal.controllers", []);

	app.controller('ModalCategoriesController', function(Terms,AutoComplete){
		var self = this;
		self.searchText = null;
		self.querySearch = AutoComplete.querySearch;
		self.items = Terms.categories;
		self.placeholder = "Enter a Category";
		self.transformChip = AutoComplete.transformChip;
	});
	app.controller("ModalAlbumsController",function( Terms, AutoComplete ){
		var self = this;
		self.searchText = null;
		self.querySearch = AutoComplete.querySearch;
		self.items = Terms.albums;
		self.placeholder = "Enter a Album";
		self.transformChip = AutoComplete.transformChipOnlyName;
	});
	app.controller("ModalTagsController",function( Terms, AutoComplete ){
		var self = this;
		self.querySearch = AutoComplete.querySearch;
		self.items = Terms.tags;
		self.placeholder = "Enter a Tag";
		self.transformChip = AutoComplete.transformChipOnlyName;
	});
})();
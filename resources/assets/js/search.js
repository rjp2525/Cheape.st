var config = function($stateProvider) {
	$stateProvider
		.state('search', {
			url: '/search/{query}',
			templateUrl: '../views/search.html',
			controller: 'SearchCtrl',
			controllerAs: 'vm'
		});
}

var searchCtrl = function($state, ProductService) {
	var vm = this;
	var query = $state.params.query;

	String.prototype.stripSlashes = function(){
	    return this.replace(/\\(.)/mg, "$1");
	}	

	vm.strip = function(string) {
		string = string.substring(2, string.length - 2);
		return string.stripSlashes();
	}
	
	vm.submit = function() {
		$state.go('search', {query: vm.search});
	} 

	ProductService.search(query)
		.then(function(response) {
			vm.products = response.data;
		});
}

angular
	.module('Search', [
		'ui.router'
	])
	.config([
		'$stateProvider',
		config
	])
	.controller('SearchCtrl', [
		'$state',
		'ProductService',
		searchCtrl
	]);
var productService = function($http, $q) {
	var ProductService = {};
	const API = 'http://69.164.209.164/v1/search?q=';

	ProductService.search = function(query) {
		var defer = $q.defer();

		$http.get(API + query)
			.then(function(response) {
				defer.resolve(response.data);
			}, function(response) {
				defer.reject('API error afoot!');
			});

		return defer.promise;
	}

	return ProductService;
}

angular
	.module('Cheapest')
	.factory('ProductService', [
		'$http',
		'$q',
		productService
	]);
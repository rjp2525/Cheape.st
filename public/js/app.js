(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var search = require('./search.js');

var run = function($rootScope, $state) {
	$rootScope.stateIsHome = function() {
		if ($state.current.name == 'home') {
			return true;
		} else {
			return false;
		}
	}
}

var config = function($stateProvider, $urlRouterProvider, $locationProvider) {
	$stateProvider
		.state('home', {
			url: '/',
			templateUrl: '../views/home.html',
			controller: 'HomeCtrl',
			controllerAs: 'vm'
		});

	$urlRouterProvider
		.otherwise('/404');

	$locationProvider
		.html5Mode(true);


}

var mainCtrl = function($state) {
	var vm = this;

	vm.submit = function() {
		$state.go('search', {query: vm.search});
	}
}

angular
	.module('Cheapest', [
		'ui.router',
		'ngAnimate',
		'Search'
	])
	.run([
		'$rootScope',
		'$state',
		run
	])
    .config([
    	'$stateProvider',
    	'$urlRouterProvider',
    	'$locationProvider',
        config
    ])
	.controller('HomeCtrl', [
		'$state',
		mainCtrl
	]);

var productService = require('./services/productService.js');
},{"./search.js":2,"./services/productService.js":3}],2:[function(require,module,exports){
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
},{}],3:[function(require,module,exports){
var productService = function($http, $q) {
	var ProductService = {};
	const API = 'http://localhost/api/v1/search?q=';

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
},{}]},{},[1]);

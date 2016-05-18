require('jquery');
require('angular');
require('angular-ui-router');
require('angular-animate');

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

var productService = require('./services/product.service.js')

var toggleClass = require('./directives/toggle-class.directive.js')
var app = angular.module('app', ['ngRoute']);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider.when('/', {
		templateUrl: 'pages/index.html'
	});

	$routeProvider.when('/device/register', {
		templateUrl: 'pages/register.html',
		controller: 'RegisterController',
		resolve: {
			data: ['$http', function($http){
				return $http.get("/register");
			}]
			// types: ['$http', function($http){
			// 	return $http.get("/register");
			// }],
			// units: ['$http', function($http){
			// 	return $http.get("/register");
			// }]
		}
	});

	$routeProvider.when('/device/list', {
		templateUrl: 'pages/list.html',
		controller: 'ListController',
		resolve: {
			data: ['$http', function($http){
				return $http.get("/device/list/data");
			}]
		}
	});

	$routeProvider.when('/device/:device/info', {
		templateUrl: 'pages/info.html',
		controller: 'DeviceInfoController',
		resolve: {
			data: ['$http', '$route', function($http, $route){
				return $http.get("/device/" + $route.current.params.device + "/data");
			}]
		}
	});

	$routeProvider.otherwise({
		redirectTo: '/'
	});

	$locationProvider.html5Mode(true);
});
var app = angular.module('app', ['ngRoute']);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider.when('/', {
		templateUrl: 'pages/index.html'
	});

	$routeProvider.when('/device/register', {
		templateUrl: 'pages/register.html',
		controller: 'RegisterController',
		resolve: {
			datas: ['$http', function($http){
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

	// $routeProvider.when('/list', {
	// 	templateUrl: 'pages/list.html',
	// 	controller: 'RoomController',
		// resolve: {
		// 	roomData: ['$http', function($http){
		// 		return $http.get("/room");
		// 	}]
		// }
	// });

	$routeProvider.otherwise({
		redirectTo: '/'
	});

	$locationProvider.html5Mode(true);
});
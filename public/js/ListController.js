app.controller('ListController', function($scope, datas){
	$scope.devices = datas.data.devices;
});
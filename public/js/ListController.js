app.controller('ListController', function($scope, $location, datas){
	$scope.devices = datas.data.devices;

	$scope.getInfo = function(device_id) {
        $location.path('/device/' + device_id + '/info');
    }
});
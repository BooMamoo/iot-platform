app.controller('ListController', function($scope, $location, data){
	$scope.devices = data.data.devices;

	$scope.getInfo = function(device_id) {
        $location.path('/device/' + device_id + "/info");
    }
});
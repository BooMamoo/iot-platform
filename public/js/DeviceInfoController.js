app.controller('DeviceInfoController', function($scope, $http, $location, data){
	$scope.device = data.data[0];

	$scope.edit = function(device_id) {
        $location.path('/device/' + device_id + "/edit");
    }

	$scope.delete = function(device_id) {
    	$http({
			method: 'POST',
		    url: '/device/delete',
		    data: {
		    	'device_id': device_id
		    }
		}).success(function(data) {
	        if(data == "true")
	        {
	            Materialize.toast("Success", 2000);
	            $location.path('/device/list');
	        }
	        else
	        {
	            Materialize.toast("Fail", 2000)
	        }
	    });
    }
});
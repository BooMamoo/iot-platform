app.controller('DeviceEditController', function($scope, $http, data, types){
	$scope.device = data.data[0];
	$scope.device_name = data.data[0].name;
	$scope.types = types.data.types;
	$scope.units = types.data.units;
	
	$scope.allType = [];

	for(var i = 0 ; i < data.data[0].mapping.length ; i++)
	{
		$scope.allType.push({'id': "type" + i, 
							 'type_id': data.data[0].mapping[i].type_id,
							 'unit_id': data.data[0].mapping[i].unit_id,
							 'formula': data.data[0].mapping[i].formula,
							 'item': "old",
							 'mapping_id': data.data[0].mapping[i].id,
							 'status': true});
	}

	$scope.numType = $scope.allType.length;

	var tmp = {}

	for(var i = 0 ; i < $scope.units.length ; i++)
	{
		if(tmp.hasOwnProperty($scope.units[i].type_id))
		{
			tmp[$scope.units[i].type_id].push($scope.units[i]);
		}
		else
		{
			tmp[$scope.units[i].type_id] = [];
			tmp[$scope.units[i].type_id].push($scope.units[i]);
		}
	}

	$scope.units = tmp;

	$scope.addNewType = function() {
		var newItemNo = $scope.allType.length + 1;
		$scope.allType.push({'id': 'type' + newItemNo,
							 'item': "new",
							 'status': true});

		$scope.numType++;
	};

	$scope.removeType = function(index) {
		console.log(index)
		if($scope.allType[index].item == "new")
		{
			$scope.allType.splice(index, 1);
		}
		else
		{
			$scope.allType[index].status = false;
		}

		$scope.numType--;
	};

	$scope.submit = function(){
		$http({
			method: 'POST',
		    url: '/device/edit',
		    data: {
		    	'device': $scope.device,
		    	'types': $scope.allType
		    }
		}).success(function(data) {
	        if(data.status == "true")
	        {
	            Materialize.toast("Success", 2000);
	        }
	        else
	        {
	            Materialize.toast("Fail", 2000)
	        }

	        $scope.device = data.device;
	        $scope.device_name = data.device.name
		   	
		   	$scope.allType = [];

			for(var i = 0 ; i < data.mapping.length ; i++)
			{
				$scope.allType.push({'id': "type" + i, 
									 'type_id': data.mapping[i].type_id,
									 'unit_id': data.mapping[i].unit_id,
									 'formula': data.mapping[i].formula,
									 'item': "old",
									 'mapping_id': data.mapping[i].id,
									 'status': true});
			}
	    });
	}
});
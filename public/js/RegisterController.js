app.controller('RegisterController', function($scope, $http, $compile, data) {
	$scope.types = data.data.types;
	$scope.units = data.data.units;
	$scope.allType = [{id: 'type1'}];
	$scope.numType = 1;

	var tmp = {}
	console.log($scope.types);
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
		$scope.allType.push({'id': 'type' + newItemNo});
		$scope.numType++;
	};

	$scope.removeType = function(index) {
		$scope.allType.splice(index, 1);
		$scope.numType--;
	}

	$scope.submit = function(){
		$http({
		    method: 'POST',
		    url: '/regis',
		    data: {
		    	'device': $scope.device,
		    	'location': $scope.location,
		    	'interval': $scope.interval,
		    	'types': $scope.allType
		    }
		}).success(function(data) {
	        if(data == "true")
	        {
	            Materialize.toast("Success", 2000);
	        }
	        else
	        {
	            Materialize.toast("Fail", 2000)
	        }

	        $scope.device = "";
		   	$scope.location = "";
		    $scope.interval = "";
		    $scope.allType = [{id: 'type1'}];
	    });
	}
});
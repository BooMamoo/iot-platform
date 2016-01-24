app.controller('RegisterController', function($scope, $http, data) {
	$scope.types = data.data.types;
	$scope.units = data.data.units;

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

	$scope.submit = function(){
		$http({
		    method: 'POST',
		    url: '/regis',
		    data: {
		    	'device': $scope.model.device,
		    	'location': $scope.model.location,
		    	'interval': $scope.model.interval,
		    	'type_id': $scope.model.idType,
		    	'unit_id': $scope.model.idUnit,
		    	'formula': $scope.model.formula
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

	        $scope.model.device = "";
		   	$scope.model.location = "";
		    $scope.model.interval = "";
		    $scope.model.formula = "";
	        $('#selectType').trigger('reset');
	        $('#selectUnit').trigger('reset');
	    });
	}

});

app.directive('myRepeatDirective', function($timeout) 
{
    return function(scope, element, attrs) 
    {
        if (element.is("option")) 
        {
            $timeout(function() {
                $('select').material_select();
            });  
        }
    };
});
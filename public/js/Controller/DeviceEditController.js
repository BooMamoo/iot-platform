app.controller('DeviceEditController', function($scope, $http, $location, data, types){
	$scope.device = data.data[0];
	$scope.device_name = data.data[0].name;
	$scope.types = types.data.types;
	$scope.units = types.data.units;
	$scope.iScrollPos = 0;
	$scope.numModal = 0;
	$scope.allType = [];
	$scope.formula = [];

    $scope.setActiveFormula = function(index) {
	    if($scope.formula[index] != "")
	    {
	        $(".formula-label-" + index).addClass("active");
	    }
	    else
	    {
	        $(".formula-label-" + index).removeClass("active");
	    }
    }

    $(window).scroll(function () {
        $scope.iScrollPos = $(this).scrollTop();

        if($scope.iScrollPos >= 67)
        {
            $(".navbar-fixed").addClass("opacity");
        }
        else if($scope.iScrollPos < 67)
        {
            $(".navbar-fixed").removeClass("opacity");
        }
    });

	for(var i = 0 ; i < data.data[0].mapping.length ; i++)
	{
		$scope.allType.push({'id': "type" + i, 
							 'type_id': data.data[0].mapping[i].type_id,
							 'unit_id': data.data[0].mapping[i].unit_id,
							 'formula': data.data[0].mapping[i].formula,
							 'item': "old",
							 'mapping_id': data.data[0].mapping[i].id,
							 'status': true});

		$scope.formula.push(data.data[0].mapping[i].formula);	
		$scope.setActiveFormula(i);
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
		$scope.formula.push("");
		$scope.numType++;
	};

	$scope.removeType = function(index) {
		if($scope.allType[index].item == "new")
		{
			$scope.allType.splice(index, 1);
			$scope.formula.splice(index, 1);
		}
		else
		{
			$scope.allType[index].status = false;
		}

		$scope.numType--;
	};

	$scope.back = function(device_id) {
		$location.path('/device/' + device_id + "/info");
	};

	$scope.submit = function() {
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

	$scope.modal = function(index) {
		$('#modal1').openModal();
		$scope.numModal = index;
	}

	$scope.close = function() {
		$('#modal1').closeModal();   
	}

	$scope.updateOutput = function (btn, index) {
		$scope.formula[index] += btn;
		$scope.allType[index].formula = $scope.formula[index];
		$scope.setActiveFormula(index);
    };

    $scope.deleteOutput = function(state, index) {
    	if(state == 'one')
    	{
    		$scope.formula[index] = $scope.formula[index].substring(0, $scope.formula[index].length - 1);
    	}
    	else if(state == 'all')
    	{
    		$scope.formula[index] = "";
    	}

    	$scope.allType[index].formula = $scope.formula[index];
    	$scope.setActiveFormula(index);
    }
});
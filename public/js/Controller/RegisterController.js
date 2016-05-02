app.controller('RegisterController', function($scope, $http, $compile, data) {
	$scope.types = data.data.types;
	$scope.units = data.data.units;
	$scope.formulas = data.data.formulas;
	$scope.allType = [{id: 'type1'}];
	$scope.numType = 1;
	$scope.iScrollPos = 0;
	$scope.formula = [""];
	$scope.numModal = 0;

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
		$scope.allType.push({'id': 'type' + newItemNo});
		$scope.formula.push("");
		$scope.numType++;
	};

	$scope.removeType = function(index) {
		$scope.allType.splice(index, 1);
		$scope.formula.splice(index, 1);
		$scope.numType--;
	}

	$scope.submit = function() {
		if($scope.device == undefined || $scope.device == "")
		{
			Materialize.toast("Please enter device name", 2000);
		}
		else if($scope.location == undefined || $scope.location == "")
		{
			Materialize.toast("Please enter device location", 2000);
		}
		else if($scope.interval == undefined || $scope.interval == null)
		{
			Materialize.toast("Please enter device interval", 2000);
		}
		else
		{
			var success = true;

			for(var i = 0 ; i < $scope.allType.length ; i++)
			{
				if(!$scope.allType[i].hasOwnProperty('type_id') || !$scope.allType[i].hasOwnProperty('unit_id') || !$scope.allType[i].hasOwnProperty('formula') || !$scope.allType[i].hasOwnProperty('min_threshold') || !$scope.allType[i].hasOwnProperty('max_threshold'))
				{
					Materialize.toast("Please complete device type", 2000);
					success = false;

					break;
				}
				else if($scope.allType[i].min_threshold == undefined || $scope.allType[i].min_threshold == null || $scope.allType[i].max_threshold == undefined || $scope.allType[i].max_threshold == null || $scope.allType[i].formula == undefined || $scope.allType[i].formula == null)
				{
					Materialize.toast("Please complete device type", 2000);
					success = false;

					break;
				}
			}

			if(success)
			{
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
				    $scope.formula = [""];
				    $scope.numModal = 0;
			    });
			}
		}
	}

	$scope.change = function(index, formula)
	{
		$scope.allType[index].formula = formula;
		$scope.formula[index]  = formula;
		$scope.setActiveFormula(index);
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

    $scope.setActiveFormula = function(index) {
        if($scope.allType[index].formula != "")
        {
            $(".formula-label-" + index).addClass("active");
        }
        else
        {
            $(".formula-label-" + index).removeClass("active");
        }
    }
});
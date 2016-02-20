app.controller('RegisterController', function($scope, $http, $compile, data) {
	$scope.types = data.data.types;
	$scope.units = data.data.units;
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
        if($scope.formula[index] != "")
        {
            $(".formula-label-" + index).addClass("active");
        }
        else
        {
            $(".formula-label-" + index).removeClass("active");
        }
    }
});
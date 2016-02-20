app.controller('ListController', function($scope, $location, data){
	$scope.devices = data.data.devices;
	$scope.tmp = data.data.devices;
	$scope.iScrollPos = 0;

    if($scope.devices.length == 0)
    {
        $scope.no_device = true;
    }
    else
    {
        $scope.no_device = false;
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

    $scope.$watch('search', function () 
    {
        if($scope.search != undefined)
        {
        	$scope.devices = [];

            for(var i = 0 ; i < $scope.tmp.length ; i++)
            {
            	if($scope.tmp[i].name.toLowerCase().search($scope.search.toLowerCase()) > -1)
            	{
            		$scope.devices.push($scope.tmp[i]);
            	}
            }

            if($scope.devices.length == 0)
            {
                $scope.no_device = true;
            }
            else
            {
                $scope.no_device = false;
            }
        }
    });

	$scope.getInfo = function(device_id) {
        $location.path('/device/' + device_id + "/info");
    }
});
app.controller('pickupCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.PickupLocArray=[];
	$scope.filterData = {};

	//alert("ssssss");


 $scope.getPickupLocataionreport = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.PickupLocArray=[];
		  }
		   Data.post('PickupLocation/showPickuploclist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.PickupLocArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};



});
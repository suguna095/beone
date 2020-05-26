app.controller('amsCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.amsListArray=[];
	$scope.filterData = {};
	 $scope.totalCount=0;
	 
	
	 $scope.ShowAmsData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.amsListArray=[];
		  }
		   Data.post('Ams/ShowAms',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.amsListArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
	
	$scope.Amsform = function (add_address) {
		  //console.log(add_route);
        Data.post('Ams/add_Address', {
            add_address: add_address
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.go('show_address');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
});

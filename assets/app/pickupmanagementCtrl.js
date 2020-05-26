app.controller('pickupmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window) {
	
	//console.log('test');
	
	$scope.filterData={};
	$scope.pickup_listData=[];
	$scope.totalCount=0;
	
	$scope.getPickupmanagementData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)  
		  {
		  $scope.pickup_listData=[];
		  }
		  
       Data.post('PickupManagement/pickup_list',$scope.filterData).then(function (results) {
			
			console.log(results);
		    
			
			 $scope.totalCount=results.count;
			 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.pickup_listData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			   
		           
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	
	});

app.controller('showpickupdetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	

	
	$scope.pickupDetailsarray={}; 
	$scope.drs_unique_id=$stateParams.drs_unique_id;
	
	$scope.showPickupdetail = function () { 
		
        Data.post('PickupManagement/show_pickup_detail', $stateParams).then(function (results) {
			console.log(results);
		   
           $scope.pickupDetailsarray=results;
        });
    };
	
	});

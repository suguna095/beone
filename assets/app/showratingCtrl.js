app.controller('showratingCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window) {
	
	console.log('test');
	
	$scope.filterData={};
	$scope.service_detailData=[];
	$scope.totalCount=0;
	
	$scope.getShowratingData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.service_detailData=[]; 
		  }
       Data.post('ShowRating/ShowratingData',$scope.filterData).then(function (results) { 
			
			console.log(results);
		    
			
			 $scope.totalCount=results.count;   
			 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.service_detailData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			 
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	/*$scope.get__drs = function () {
       Data.get('ContentServices/get_detail_drs').then(function (results) { 
		   
			console.log(results);
			
		    $scope.get_show_drs=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };*/
	
	$scope.DropDriversData=function()
	{
	 Data.post('ShowRating/showDriverDrop',$scope.filterData).then(function (results) { 
			
			//console.log(results);
		    
			
			 $scope.DriverlistArray=results;
	 });			 
	};
	});


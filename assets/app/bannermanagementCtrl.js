app.controller('bannermanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.BannerlistArray=[];
	$scope.filterData = {};
	 $scope.totalCount=0;
	
	$scope.bannerArray={};
	$scope.editbannerArray={};
	 $scope.getBannerlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.BannerlistArray=[];
		  }
		   Data.post('BannerManagement/showBannerlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.BannerlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
	$scope.AddBannerform = function (add_banner) {
		//console.log(add_banner);
        Data.post('BannerManagement/add_bannerList', {
            add_banner: add_banner
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_banner');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	$scope.EditBannerform = function (edit_banner) {
		//console.log(news);
        Data.post('BannerManagement/Banner_update', {
            edit_banner: $scope.editbannerArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_banner');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	
	$scope.formeditbannershow=function(custdata)
	{
		
		Data.post('BannerManagement/geteditbannerData', {banid:$stateParams.banid}).then(function (results) {
		//	console.log(results);
			$scope.editbannerArray=results;
			$scope.editbannerArray.banid= $stateParams.banid; 

        });
	};
   
});

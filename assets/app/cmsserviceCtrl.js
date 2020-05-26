app.controller('cmsserviceCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.viewcmsData=[];
    $scope.filterData={};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
$scope.editcmsArray={};

	
    $scope.viewcmspage = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewcmsData=[];
		  }
		   Data.post('CmsPages/show_cmsservice',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.viewcmsData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};

$scope.EditCMSshow=function(custdata)
	{
		
		Data.post('CmsPages/geteditCMSData', {id:$stateParams.id}).then(function (results) {
			console.log(results);
			$scope.editcmsArray=results;
			$scope.editcmsArray.id= $stateParams.id;

        });
	};
	

$scope.CMS_update = function (custdata) {
		console.log(custdata);
        Data.post('CmsPages/CMS_update', {
            custdata: $scope.editcmsArray
        }).then(function (results) {
			console.log(results);
		   
            if (results=='true') {
				// Data.toast(results);
				$state.go('cms_pages');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };



});
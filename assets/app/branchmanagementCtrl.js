app.controller('branchmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.BranchlistArray=[]; 
	$scope.filterData = {};
	 $scope.totalCount=0;
	$scope.routeArray={};
	$scope.editbranchArray={};
	
	 $scope.getBranchlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.BranchlistArray=[];
		  }
		   Data.post('BranchManagement/showBranchlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.BranchlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
	$scope.GetBranchdelete = function (id) {
		//alert (id); 
        Data.post('BranchManagement/get_delete_branch', {id:id}).then(function (results) {    
			console.log(results);
		   $state.reload();
        });
    };
	
	$scope.Addbranchform = function (add_branch) {
		  console.log(add_branch);
        Data.post('BranchManagement/add_branch', {
            add_branch: add_branch
        }).then(function (results) { 
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.go('show_branch');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	$scope.Editbranchshow=function(custdata)
	{
		
		Data.post('BranchManagement/geteditbranchData', {branchid:$stateParams.branchid}).then(function (results) {
		//	console.log(results);
			$scope.editbranchArray=results;
			$scope.editbranchArray.branchid= $stateParams.branchid;

        });
	};
	
	$scope.EditBranchform = function (edit_branch) {
	    console.log(edit_branch);  
        Data.post('BranchManagement/edit_branchform', {
            edit_branch: $scope.editbranchArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully"); 
				  $state.go('show_branch');   
				
            }
			else
			{
				alert("all field are required"); 
			//$scope.errormess=results.error;
			}
        });
    };
	
		$scope.ShowactiveStatus = function (id,status) {
		
        Data.post('BranchManagement/GetstaffstatusUpdate', {id:id,status:status}).then(function (results) { 
			console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };
	
	$scope.ShowBranchCityDrop=function()
	{
	 Data.post('BranchManagement/BranchCityDrop').then(function (results) {
		//	console.log(results);
			$scope.BranchCityArray=results;
	 });
	};
	
});

app.controller('contentservicesCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	console.log('test');
	$scope.editserveArray={};
	$scope.filterData={};
	$scope.service_detailData=[];
	$scope.totalCount=0;
	
	$scope.getContentservicesData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.service_detailData=[];
		  }
       Data.post('ContentServices/getContentData',$scope.filterData).then(function (results) { 
			
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
 
        });
    };
	
	$scope.AddServicesform = function (add_services) {
		  //console.log(add_services);
        Data.post('ContentServices/AddContent', {
            add_services: add_services
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Inserted Successfully");
				$state.reload(); 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	 $scope.GetContentrdelete = function (id) {
		//alert (id); 
        Data.post('ContentServices/get_delete_content', {id:id}).then(function (results) { 
			console.log(results);
			alert("Deleted Successfully");
			$state.reload();	 
		    
        });
    };
	
	$scope.EditContentshow=function()
	{
		
		Data.post('ContentServices/ShowEditcontent', {conid:$stateParams.conid}).then(function (results) {
		//	console.log(results);
			$scope.editserveArray=results;
			$scope.editserveArray.conid= $stateParams.conid;

        });
	};
	
	$scope.EditServicesform = function (edit_services) {
	    console.log(edit_services);  
        Data.post('ContentServices/EditContent', {
            edit_services: $scope.editserveArray  
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('content_services');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	 
	 $scope.ShowactiveStatus = function (id,status) {
		
        Data.post('ContentServices/GetstaffstatusUpdate', {id:id,status:status}).then(function (results) { 
			//console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };
	
	
	});


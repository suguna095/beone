app.controller('servicesmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
  
	
	
	 $scope.ShowServicesData = function () {
		 
		   Data.post('ServicesManagement/ViewServicelist').then(function (results) {
			   
			   console.log(results);
			   $scope.ServicesList=results;
			});
		};
   
	$scope.GetServicesdelete = function (id) {
		//alert (id); 
        Data.post('ServicesManagement/get_delete_services', {id:id}).then(function (results) { 
			console.log(results);
			alert("Deleted Successfully");
			$state.reload();
		   
          // $scope.edit_compidArray=results;
        });  
    };
	
	$scope.UpdateactiveStatus = function (id,status) {
		
        Data.post('ServicesManagement/GetServicetatusUpdate', {id:id,status:status}).then(function (results) { 
			console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };
	
	
	$scope.AddServiceName = function (add_service) {
		  //console.log(add_service);
        Data.post('ServicesManagement/AddServices', {
            add_service: add_service
        }).then(function (results) {
			console.log(results);   

            if (results== 'true') {
				// Data.toast(results);
				alert("Added Successfully");
				$state.go('view_services');	
				
            }
			else
				
			{
				alert("Already Exit");
			
			}
        });
    };
	
	$scope.EditServicesshow=function(custdata)
	{
		
		
		Data.post('ServicesManagement/ShowEditService', {id:$stateParams.id}).then(function (results) {
		//	console.log(results);
			$scope.serviceeditArray=results;
			$scope.serviceeditArray.id= $stateParams.id;
			//$scope.ShowRouteCityDrop($scope.editrouteArray.country_id);

        });
	};
	
	$scope.UpdateServiceName = function (edit_service) {
		//console.log(edit_service); 
        Data.post('ServicesManagement/UpdateService', {
            edit_service: $scope.serviceeditArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully");
				$state.go('view_services');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
});

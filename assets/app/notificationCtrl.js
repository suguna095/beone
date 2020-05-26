app.controller('notificationCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
    $scope.NotificationlistArray=[]; 
	$scope.filterData = {};
	$scope.totalCount=0;
    $scope.editnotificationArray={};
	
	angular.element(document).ready(function () {
    
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    }); 
	
	 $scope.getNotificationlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no; 
		  if(reset==1)
		  {
		  $scope.NotificationlistArray=[];
		  }
		   Data.post('Notification/showNotificationlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.NotificationlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
   $scope.ShowactiveStatus = function (id,status) {
		//alert(id);
        Data.post('Notification/GetActivestatusUpdate', {id:id,status:status}).then(function (results) { 
			console.log(results);
			//alert("Updated Successfully");
			//alert(sssss);  
		    $state.reload();  
        });
    };
	
	
	$scope.GetNotifydelete = function (id) {
		//alert (id); 
        Data.post('Notification/get_delete_notify', {id:id}).then(function (results) { 
			console.log(results);
			alert("Deleted Successfully");
		    $state.reload(); 
        });
    };
	
	$scope.AddNotificationform = function (add_notification) {
		  //console.log(add_route);
        Data.post('Notification/AddNotification', {
            add_notification: add_notification
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Inserted Successfully");
				$state.go('show_notification');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	$scope.EditNotifyshow=function(custdata)
	{
		
		Data.post('Notification/geteditNotifyData', {notifyid:$stateParams.notifyid}).then(function (results) {
		//	console.log(results);
			$scope.editnotificationArray=results;
			$scope.editnotificationArray.notifyid= $stateParams.notifyid;

        });
	};
	
	$scope.EditNotificationform = function (edit_notification) {
	    //console.log(edit_staff);  
        Data.post('Notification/edit_notifyform', {
            edit_notification: $scope.editnotificationArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				alert("Updated Successfully");
				$state.go('show_notification'); 
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
});

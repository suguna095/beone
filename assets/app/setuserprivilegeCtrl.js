app.controller('setuserprivilegeCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window) {
	
	$scope.privilege_detailsData={};
	$scope.UsersData={};
	$scope.filterData={};
	$scope.UpdateData={};
	
	  $scope.getUserprivilegeData = function(user_id) {
		
		 $scope.filterData.user_id=user_id;
           Data.post('SetUserPrivilege/getUserprivilegeData',$scope.filterData).then(function (results) { 
			console.log(results);
			 $scope.privilege_detailsData=results;   
			
        });
    };
	
	 $scope.Getuserlistpre = function () {
		  Data.post('SetUserPrivilege/GetallUserlistData').then(function (results) { 
			//console.log(results);
			 $scope.UsersData=results;   
			
        });
	 }
	  $scope.GetupdatePrivilageData = function (onoff_true_false,id) {
		 // alert(onoff_true_false);
		 $scope.UpdateData.onoff_true_false=onoff_true_false;
		 $scope.UpdateData.id=id;
		 $scope.UpdateData.user_id=$scope.filterData.user_id;
		 
		
		  Data.post('SetUserPrivilege/setCustomerPrivilage',$scope.UpdateData).then(function (results) { 
			console.log(results);
			 //$scope.UsersData=results;   
			
        });
	 }
	 
	 
	});


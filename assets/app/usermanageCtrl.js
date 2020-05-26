app.controller('usermanageCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window) {
    //initially set those objects to null to avoid undefined error
    $scope.listData = {};
	
	//alert("ssssss");
    $scope.showuserlist = function () {
       Data.get('UserManagement/showUserListData').then(function (results) {
			//console.log(results);
			$scope.listData=results;
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
   
   
  
});

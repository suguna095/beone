app.controller('seoCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.seoData = {};
	$editseoArray = {};
	//alert("ssssss");
    $scope.showseo = function () {
       Data.get('Seo/showseoData').then(function (results) {
			//console.log(results);
			
		    $scope.seoData=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
    
    $scope.Editseoshow=function(custdata)
	{
		
		Data.post('Seo/getSeoData', {seoid:$stateParams.seoid}).then(function (results) { 
		//	console.log(results);
			$scope.editseoArray=results;
			$scope.editseoArray.seoid= $stateParams.seoid;

        });
	};
   
    
	$scope.EditSeoform = function (edit_seo) {
	    //console.log(edit_staff);  
        Data.post('Seo/edit_seoform', {
            edit_seo: $scope.editseoArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully");
				$state.go('seo');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
   
	
});

app.controller('emailtemplatesCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.emailData = {};
	$editmailArray = {};
	//alert("ssssss");
    $scope.showEmailTemplates = function () {
       Data.get('EmailTemplates/showemailData').then(function (results) {
			//console.log(results);
			
		    $scope.emailData=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
    
    $scope.EditEmailshow=function(custdata)
	{
		
		Data.post('EmailTemplates/getEditEmailData', {mailid:$stateParams.mailid}).then(function (results) { 
		//	console.log(results);
			$scope.editmailArray=results;
			$scope.editmailArray.mailid= $stateParams.mailid;

        });
	};
   
    
	$scope.EditMailform = function (edit_mails) {
	    //console.log(edit_staff);  
        Data.post('EmailTemplates/edit_mailform', {
			  edit_mails: $scope.editmailArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully");
				$state.go('email_setting');  
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
   
	
});

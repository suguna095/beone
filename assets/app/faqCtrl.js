app.controller('faqCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.faqData = {};
	$scope.editfaqArray={};
	//alert("ssssss");
    $scope.showfaq = function () {
       Data.get('Faq/showfaqData').then(function (results) {
			//console.log(results);
			
		    $scope.faqData=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
    
    
   $scope.GetFaqdelete = function (id) {
		//alert (id); 
        Data.post('Faq/get_delete_faq', {id:id}).then(function (results) { 
			console.log(results); 
			$state.reload();	
		    if (results== 'true') {
				alert("Deleted Successfully");  
		
            }
			else
				
			{
				alert("all field are required");  
			
			}
          // $scope.edit_compidArray=results;
        });
    };
    
	
	$scope.AddFaqform = function (add_faq) {
		  //console.log(add_route);
        Data.post('Faq/add_faq', {
            add_faq: add_faq
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Added Successfully"); 
				$state.go('show_faq');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
   
   $scope.EditFaqshow=function(custdata)
	{
		
		Data.post('Faq/geteditfaqData', {faqid:$stateParams.faqid}).then(function (results) { 
		//	console.log(results);
			$scope.editfaqArray=results;
			$scope.editfaqArray.faqid= $stateParams.faqid;

        });
	};
	
	$scope.EditFaqForm = function (edit_faq) {
	    //console.log(edit_staff);  
        Data.post('Faq/edit_faqform', {
            edit_faq: $scope.editfaqArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully"); 
				$state.go('show_faq');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
});

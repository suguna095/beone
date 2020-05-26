app.controller('pickuplocationCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.newArray = {};
	 $scope.editArray = {};
	$scope.ListArray = {};
	$scope.ckdata = {
      textInput: 'pretext',
      options: {
        language: 'en',
        allowedContent: true,
        entities: false
      }
	}
	
	  
       
	 
	//console.log($scope.editArray);
	//alert("ssssss");
    $scope.Addform = function (pickuplocation) {
		//console.log(news);
        Data.post('PickupLocation/show_location', {
            pickuplocation: pickuplocation
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_location');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	 $scope.Addform_update = function (PickupLocation) {
		//console.log(pickuplocation);
        Data.post('PickupLocation/Addform_update', {
            news: $scope.editArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_location');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	$scope.showlistdata=function(pickuplocation){
		//alert("sssss");
		  Data.post('PickupLocation/Getlist', {
            news: news
        }).then(function (results) {
			//console.log(results);
			$scope.ListArray=results;
			
		   
           
        });
	};
	$scope.formeditdatashow=function(custdata)
	{
		
		Data.post('PickupLocation/geteditshowData', {editid:$stateParams.editid}).then(function (results) {
		//	console.log(results);
			$scope.editArray=results;
			$scope.editArray.editid= $stateParams.editid;

        });
	};
   
   
   
});

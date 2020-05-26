app.controller('newsCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
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
	
	  $scope.isPanelVisible = false;
	var bodyElement = document.getElementById("dialog");
	
	$scope.showDialog = function () {
		$scope.isPanelVisible = true;
		bodyElement.classList.add('noscroll');
	};
	$scope.hideDialog = function () {
		$scope.isPanelVisible = false;
		bodyElement.classList.remove('noscroll');
	};
       
	 
	//console.log($scope.editArray);
	//alert("ssssss");
    $scope.Addform = function (news) {
		//console.log(news);
        Data.post('News/add_news', {
            news: news
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_news');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	 $scope.Addform_update = function (news) {
		//console.log(news);
        Data.post('News/Addform_update', {
            news: $scope.editArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_news');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	$scope.showlistdata=function(news){
		//alert("sssss");
		  Data.post('News/Getlist', {
            news: news
        }).then(function (results) {
			//console.log(results);
			$scope.ListArray=results;
			
		   
           
        });
	};
	$scope.formeditdatashow=function(custdata)
	{
		
		Data.post('News/geteditshowData', {editid:$stateParams.editid}).then(function (results) {
		//	console.log(results);
			$scope.editArray=results;
			$scope.editArray.editid= $stateParams.editid;

        });
	};
   
   
   
});


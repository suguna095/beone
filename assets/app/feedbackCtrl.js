app.controller('feedbackCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.FeedbackArray=[];
	$scope.filterData = {};
    $scope.filterData.searchfield ="";
	$scope.totalCount=0;
	//alert("ssssss");
	angular.element(document).ready(function () {
    
		$( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
		$( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	   
		
	   });

$scope.isPanelVisible = false;
	var bodyElement = document.getElementById("dialog");
	
	
 $scope.getFeedbackreport = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.FeedbackArray=[];
		  }
		   Data.post('NewFeedback/showFeedbacklist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.FeedbackArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};



});
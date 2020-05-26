app.controller('rtomanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.RtolistArray=[];
   $scope.PendinglistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
	$scope.routeArray={};
	$scope.editstaffArray={};
	
	
	 function disableScreen(val) {
			if(val==1)
			{
			var div= document.createElement("div");
			div.className += "overlay";
			document.body.appendChild(div);
			}
			else
			 $("div").removeClass("overlay");
           }
		   
	 angular.element(document).ready(function () {
    
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    });
	 $scope.ShowRtolist = function (page_no,reset) {
		 disableScreen(1);
		 $scope.loadershow=true; 
		 $scope.filterData.rto_status='Y';
		 $scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.RtolistArray=[];
		  }
		   Data.post('RtoManagement/GetshowRto',$scope.filterData).then(function (results) {
			      disableScreen(0);
                 $scope.loadershow=false; 
				
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.RtolistArray.push(value);

                        });
                    }
					else
					{
						$scope.nodata=true  
                    }
				
			});
		}; 
   
	$scope.ShowPendinglist = function (page_no,reset) {
		 disableScreen(1);
		 
		 $scope.filterData.rto_status='N';
		// $scope.loadershow=true; 
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.PendinglistArray=[];
		  }
		   Data.post('RtoManagement/GetshowRto',$scope.filterData).then(function (results) {
			    disableScreen(0);
		 //$scope.loadershow=false; 
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.PendinglistArray.push(value);

                        });
                    }
					else
					{
						$scope.nodata=true  
                    }
			});
		}; 
		
		$scope.ShowRtoCityDrop=function()
	{
		// disableScreen(1);
		// $scope.loadershow=true; 
	    Data.post('RtoManagement/RtoCityDrop').then(function (results) {
		//	console.log(results);
		// disableScreen(0);
		// $scope.loadershow=false; 
			$scope.RtolistCityArray=results;
			$scope.shelvearray=[];
				angular.forEach($scope.RtolistCityArray, function(results){
					$scope.shelvearray.push(results.city);        
				});
				
				var input = document.getElementById("show_city_dropdown");
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;
				console.log($scope.shelvearray);

	 });
	};
});

app.controller('rtoDetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	//console.log('test');
	
	$scope.filterData={};
	$scope.drsData=[];
	$scope.totalCount=0;
	$scope.useradmin=[];
	
	$scope.editRtoDataArray={}; 
	//$scope.editnotdelivereddrsDataArray={}; 
	//$scope.editdelivereddrsDataArray={}; 
	$scope.uidshow=$stateParams.drs_unique_id;
	
		$scope.ShowRtoDetailData=function(custdata)
	{
		//alert(custdata);
		Data.post('RtoManagement/getRtoDetailData', {drs_unique_id:$stateParams.drs_unique_id}).then(function (results) {
			console.log(results);
			$scope.editRtoDataArray=results.totaldrs;  
			$scope.useradmin=results.useradmin; 
			//$scope.totaldrs=results.drsnewInfo; 
			//$scope.totaldrs.drs_unique_id= $stateParams.drs_unique_id;
  
        });  
	};

	$scope.isAll = false;
	$scope.selectAllFriendsreturn = function() {
		if($scope.isAll === false) {
			angular.forEach($scope.editRtoDataArray, function(data){
				data.checked = true;
			}); 
			$scope.isAll = true;
		} else {
			angular.forEach($scope.editRtoDataArray, function(data){
				data.checked = false;
			});
			$scope.isAll = false;
		}
	};



	$scope.ShowupdateRTOData=function(custdata)
	{
		//alert(custdata);
		Data.post('RtoManagement/getUpdateRtoDetailData', {drs_unique_id:$stateParams.drs_unique_id}).then(function (results) {
			console.log(results);
			$scope.editRtoDataArray=results.totaldrs;  
			$scope.useradmin=results.useradmin; 
			//$scope.totaldrs=results.drsnewInfo; 
			//$scope.totaldrs.drs_unique_id= $stateParams.drs_unique_id;
  
        });  
	};
	

	$scope.GetupdateChekData= function(dataArr)
	{
		
		 var itemList = [];  
        angular.forEach(dataArr, function(value, key) {  
            if (dataArr[key].checked) {     
                itemList.push(dataArr[key].id);    
            }  
        }); 
		 Data.post('RtoManagement/GetupdatemanifestChekData',itemList).then(function (results) {
			if(results=='true')
			{
				alert("successfully Added");
				 $window.location.reload();
			}
			else
			alert("try again");
		});
		
		
		
	}


	$scope.updateRToStatus = function (id) {
		//alert (id); 
        Data.post('RtoManagement/update_Rto', {id:id}).then(function (results) { 
			console.log(results);
			alert("successfully Updated");
				$state.reload(); 
				
            
		});
	}		

	 $scope.GetRtodelete = function (id) {
		//alert (id); 
        Data.post('RtoManagement/delete_Rto', {id:id}).then(function (results) { 
			console.log(results);
			alert("successfully deleted");
				$state.reload();  
				
            
		});
	}	
	 });
	 

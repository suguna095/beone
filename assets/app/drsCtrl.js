app.controller('drsCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window) {
	
	console.log('test');
	
	$scope.filterData={};
	$scope.drsData=[];
	$scope.totalCount=0;
	
	$scope.getDrsData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.drsData=[];
		  }
       Data.post('DeliveryRunSheet/getDrsData',$scope.filterData).then(function (results) {
			
			console.log(results);
		   
			 $scope.totalCount=results.count;
			 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.drsData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			 
		          });
    };
	
	

		
		
	$scope.get_show_drs = function () {
       Data.get('DeliveryRunSheet/get_detail_drs').then(function (results) { 
		   
			console.log(results);
			
		    $scope.get_show_drs=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	});

app.controller('drsDetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	//console.log('test');
	
	$scope.filterData={};
	$scope.drsData=[];
	$scope.totalCount=0;
	$scope.editdrsDataArray={}; 
	
		$scope.getDrsDetailData=function(custdata)
	{
		
		Data.post('DeliveryRunSheet/getDrsDetailData', {drs_unique_id:$stateParams.drs_unique_id}).then(function (results) {
		//	console.log(results);
			$scope.editdrsDataArray=results; 
			$scope.editdrsDataArray.drs_unique_id= $stateParams.drs_unique_id;

        });
	};
	
	
/*	$scope.getDrsDetailData1 = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1) 
		  {
		  $scope.drsData=[];
		  }
       Data.post('DeliveryRunSheet/getDrsDetailData',$stateParams).then(function (results) {
			
			console.log(results);
		    
			
			 $scope.totalCount=results.count;
			 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.drsData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    }; */
	$scope.get_show_drs = function () {
       Data.get('DeliveryRunSheet/get_detail_drs').then(function (results) { 
		   
			console.log(results);
			
		    $scope.get_show_drs=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	});
app.controller('deliveryDetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	console.log('test');
	
	$scope.filterData={};
	$scope.drsData=[];
	$scope.totalCount=0;
	
	$scope.getDeliveryDetailData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.drsData=[];
		  }
       Data.post('DeliveryRunSheet/getDeliveryDetailData',$stateParams).then(function (results) {
			
			console.log(results);
		    
			
			 $scope.totalCount=results.count;
			 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.drsData.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	$scope.get_show_drs = function () {
       Data.get('DeliveryRunSheet/get_detail_drs').then(function (results) { 
		   
			console.log(results);
			
		    $scope.get_show_drs=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	});
app.controller('notdeliveryDetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	console.log('test');
	
	$scope.filterData={};
	$scope.drsData=[];
	$scope.totalCount=0;
	
	$scope.getDrsDetailData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.drsData=[];
		  }
       Data.post('DeliveryRunSheet/getDrsDetailData',$stateParams).then(function (results) {
			
			console.log(results);
		    
			
			 $scope.totalCount=results.count;
			 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.drsData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	$scope.get_show_drs = function () {
       Data.get('DeliveryRunSheet/get_detail_drs').then(function (results) { 
		   
			console.log(results);
			
		    $scope.get_show_drs=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	
	
	  $scope.printToCart = function(printSectionId) {
        var innerContents = document.getElementById(printSectionId).innerHTML;
        var popupWinindow = window.open('', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
        popupWinindow.document.open();
        popupWinindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + innerContents + '</html>');
        popupWinindow.document.close();
      }
	  
	  
	});

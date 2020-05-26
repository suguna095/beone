app.controller('drsCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window) {
	
	//console.log('test');
	
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

app.controller('drsDetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	//console.log('test');
	
	$scope.filterData={};
	$scope.drsData=[];
	$scope.totalCount=0;
	$scope.useradmin=[];
	
	$scope.editdrsDataArray={}; 
	$scope.editnotdelivereddrsDataArray={}; 
	$scope.editdelivereddrsDataArray={}; 
	$scope.uidshow=$stateParams.drs_unique_id;
		$scope.getDrsDetailData=function(custdata)
	{
		//alert(custdata);
		Data.post('DeliveryRunSheet/getDrsDetailData', {drs_unique_id:$stateParams.drs_unique_id}).then(function (results) {
			console.log(results);
			$scope.editdrsDataArray=results.totaldrs; 
			$scope.useradmin=results.useradmin; 
			//$scope.totaldrs=results.drsnewInfo; 
			//$scope.totaldrs.drs_unique_id= $stateParams.drs_unique_id;
  
        });  
	};
	 
	
	$scope.getnotDrsDetailData=function(drs_unique_id)
	{
		//alert(drs_unique_id);
		Data.post('DeliveryRunSheet/getnotDrsDetailData', {drs_unique_id:$stateParams.drs_unique_id}).then(function (results) {
			console.log(results);
			$scope.editnotdelivereddrsDataArray=results.totaldrs; 
			$scope.useradmin=results.useradmin; 
			//$scope.totaldrs=results.drsnewInfo; 
			//$scope.totaldrs.drs_unique_id= $stateParams.drs_unique_id;
  
        });  
	};
	
	
	$scope.getDeliveryDetailData=function(drs_unique_id)
	{
		//alert(delivery_status);
		Data.post('DeliveryRunSheet/getDeliveredDrsDetailData', {drs_unique_id:$stateParams.drs_unique_id}).then(function (results) {
			console.log(results);
			$scope.editdelivereddrsDataArray=results.totaldrs; 
			$scope.useradmin=results.useradmin; 
			//$scope.totaldrs=results.drsnewInfo; 
			//$scope.totaldrs.drs_unique_id= $stateParams.drs_unique_id;
  
        });  
	};
	
	
	$scope.GetShipmentdelete = function (id) {
		//alert (id); 
        Data.post('DeliveryRunSheet/delete_drs', {id:id}).then(function (results) { 
			console.log(results);
			alert("successfully deleted");
				$state.reload(); 
				
            
		});
	}		
		    
    $scope.updateShipmentStatus = function (id) {
		//alert (id); 
        Data.post('DeliveryRunSheet/update_drs', {id:id}).then(function (results) { 
			console.log(results);
			alert("successfully Updated");
				$state.reload(); 
				
            
		});
	}		

	
	
/*	$scope.getDrsDetailData = function (page_no,reset) {
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
    };*/
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
        popupWinindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="https://lm.beone.com.sa/assets/dist/css/style.css" /></head><body onload="window.print()">' + innerContents + '</html>');
        popupWinindow.document.close();
		
      }      
	  
	  
	});
app.controller('deliveryDetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	//console.log('test');
	
	$scope.filterData={};
	$scope.drsData=[];
	$scope.totalCount=0;
	$scope.uidshow=$stateParams.drs_unique_id;
	
	
			$scope.getDeliveryDetailData=function(custdata)
	{
		alert(custdata);
		Data.post('DeliveryRunSheet/getDeliveryDetailData', {drs_unique_id:$stateParams.drs_unique_id}).then(function (results) {
			console.log(results);
			$scope.editdrsDataArray=results.totaldrs; 
			$scope.useradmin=results.useradmin; 
			//$scope.totaldrs=results.drsnewInfo; 
			//$scope.totaldrs.drs_unique_id= $stateParams.drs_unique_id;
  
        });  
	};
   
  

	
/*	$scope.getDeliveryDetailData = function (page_no,reset) {
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
    }; */
	$scope.get_show_drs = function () {
       Data.get('DeliveryRunSheet/get_detail_drs').then(function (results) { 
		   
			console.log(results);
			
		    $scope.get_show_drs=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	});
app.controller('notdeliveryDetailCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
	
	//console.log('test');
	
	$scope.filterData={};
	$scope.editdrsDataArray=[];
	$scope.totalCount=0;
	$scope.uidshow=$stateParams.drs_unique_id;
	$scope.getDrsDetailData = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.editdrsDataArray=[];
		  }
       Data.post('DeliveryRunSheet/getDrsDetailData',$stateParams).then(function (results) {
			
			console.log(results);
		       
			
			 $scope.totalCount=results.count;
			 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.editdrsDataArray.push(value);

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

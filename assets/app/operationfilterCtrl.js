app.controller('operationfilterCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams,Excel, $timeout) {
    //initially set those objects to null to avoid undefined error
    $scope.ordernotpickedlistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0; 
	$scope.orderofdissuelistArray=[];
	$scope.ordershipmentlistArray=[];
	$scope.ordercsalistArray=[];
	$scope.ordercsaloclistArray=[];
	$scope.orderdriverArray=[];
	$scope.ordernotdispatchArray=[];
	 $scope.orderupdateArray=[];
	//alert("ssssss");

	angular.element(document).ready(function () {
   
		$( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
		$( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});  
	   
		
	   });


 $scope.getordernotpickedlist = function (page_no,reset) {  
 //alert("sss");
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ordernotpickedlistArray=[];
		  }
		   Data.post('OperationFilter/getordernotpickedlist',$scope.filterData).then(function (results) { 
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ordernotpickedlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};


 $scope.getofdissuelist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.orderofdissuelistArray=[];
		  }
		   Data.post('OperationFilter/showofdissuelist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.orderofdissuelistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};


$scope.getshipments_holdlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ordershipmentlistArray=[];
		  }
		   Data.post('OperationFilter/showgetlocationlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ordershipmentlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};


		$scope.getcsaschedulelist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ordercsalistArray=[];
		  }
		   Data.post('OperationFilter/showgetcsaschedulelist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count; 
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ordercsalistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};


          $scope.ordercsalistExcelArray={}; 
        $scope.getcsaschedulelistExcel = function () {
       Data.post('OperationFilter/showgetcsaschedulelistExcel').then(function (results) { 
			//console.log(results); 
			
		    $scope.ordercsalistExcelArray=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };


     $scope.ordernotpickExcelArray={}; 
        $scope.OrderNotPickedExcel = function () {
       Data.post('OperationFilter/getordernotpickedlistExcel').then(function (results) { 
			//console.log(results); 
			
		    $scope.ordernotpickExcelArray=results; 
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };

       $scope.OfdExcelListArray={}; 
        $scope.GetOfdExcelShow = function () {
       Data.post('OperationFilter/showofdissuelistExcel').then(function (results) { 
			//console.log(results); 
			
		    $scope.OfdExcelListArray=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
      
	  
	  $scope.ShipmentHoldExcellist={}; 
        $scope.ShipmentHoldExcel = function () {
       Data.post('OperationFilter/showgetlocationlistExcel').then(function (results) { 
			//console.log(results); 
			
		    $scope.ShipmentHoldExcellist=results;  
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
   
	$scope.ShipmentDriverExcellist={}; 
	$scope.ShipmentDriverExcel = function () {
   Data.post('OperationFilter/showgetDriverlistExcel').then(function (results) { 
		//console.log(results); 
		
		$scope.ShipmentDriverExcellist=results;  
		
	   
	  // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
	});
};

      $scope.FutureExcelList={}; 
        $scope.FutureUpdateExcel = function () {
       Data.post('OperationFilter/showgetupdatelistExcel').then(function (results) { 
			//console.log(results); 
			
		    $scope.FutureExcelList=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	  
	  
	   $scope.SchedulenotdispExcellist={}; 
        $scope.ScheduleNotDispaExcel = function () {
       Data.post('OperationFilter/showgetnotdispatchlistExcel').then(function (results) { 
			//console.log(results); 
			
		    $scope.SchedulenotdispExcellist=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };

		$scope.getcsalocationlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ordercsaloclistArray=[];
		  }
		   Data.post('OperationFilter/showgetlocationlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ordercsaloclistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};


		$scope.getdriverlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.orderdriverArray=[];
		  }
		   Data.post('OperationFilter/showgetdriverlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.orderdriverArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};


		$scope.getnotdispatchlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ordernotdispatchArray=[];
		  }
		   Data.post('OperationFilter/showgetnotdispatchlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ordernotdispatchArray.push(value);

                        });
                    }
					else
					{
						$scope.nodata=true 
                    }
			});
		};


		 $scope.getupdatelist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.orderupdateArray=[];
		  }
		   Data.post('OperationFilter/showgetupdatelist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.orderupdateArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};
		
     $scope.exportToExcel = function (tableId) { // ex: '#my-table'

            var exportHref = Excel.tableToExcel(tableId, 'sheet name');
            $timeout(function () { location.href = exportHref; }, 100); // trigger download
        }
});


app.factory('Excel', function ($window) {
    var uri = 'data:application/vnd.ms-excel;base64,',
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) { return $window.btoa(unescape(encodeURIComponent(s))); },
        format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) };
    return {
        tableToExcel: function (tableId, worksheetName) {
            var table = $(tableId),
                ctx = { worksheet: worksheetName, table: table.html() },
                href = uri + base64(format(template, ctx));
            return href;
        }
    };
})
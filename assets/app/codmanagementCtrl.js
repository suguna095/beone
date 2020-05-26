app.controller('codmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.CodlistArray=[];
   $scope.PandinglistArray=[];
	$scope.filterData = {};
	$scope.filterData1 = {};
	$scope.filterData.searchfield ="";
	$scope.filterData.searchpending ="";
	$scope.GetAccountlist={};
	 $scope.totalCount=0;
	$scope.routeArray={};
	$scope.editcustomerArray={};
	$scope.totalcodlist={};
	angular.element(document).ready(function () {
     $(".select2").select2();
	 $( "#datepicker1").datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2").datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker3").datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker4").datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 
    });
	
	
	 $scope.getCodlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no; 
		  if(reset==1)
		  {
		  $scope.CodlistArray=[];
		  }
		   Data.post('CodManagement/codShipment',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
                          $scope.CodlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};
   
    $scope.getPendingCodlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no; 
		  if(reset==1)
		  {
		  $scope.PandinglistArray=[];  
		  }
		   Data.post('CodManagement/PendingShipment',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)  
						{
                          $scope.PandinglistArray.push(value);

                        });
                    }
					else
					{
						$scope.nodata=true 
                    }
			});
		};
   
   $scope.ShowCodCityDrop=function()
	{
	 Data.post('CodManagement/CodCityDrop').then(function (results) {
			//console.log(results);
			$scope.CodlistCityArray=results;
	 });
	};
	
		$scope.gettotalcod=function(custdata)
	{   
		//alert("HIii");
		Data.post('CodManagement/ShowtotalcodDetails', {drs_unique_id:$stateParams.drs_unique_id,codstatus:$stateParams.codstatus}).then(function (results) {
			console.log(results);
			$scope.totalcodlist=results.result;  

		
        });
	};
	
	
	$scope.GetConfirm = function(id,drs_unique_id)
	{
		//alert(drs_unique_id);
        Data.post('CodManagement/getconfirmCOD', {id:id,drs_unique_id:drs_unique_id}).then(function (results) { 
		console.log(results);
		alert("Status Updayed Successfully");
		 $state.reload();
		    
        });
    };


$scope.getPrintlist= function(start_date,end_date)
	{
     alert("Hi");
		//console.log(start_date,end_date);
        Data.post('CodManagement/printCODList', {start_date:start_date,end_date:end_date}).then(function (results) { 
		console.log(results);
		//alert("Status Updayed Successfully");  
		 //$state.reload();
		    
        });
    };

$scope.getexcelList = function () { // ex: '#my-table'

			//console.log($scope.exportlimit);  
//alert("Hi");
           //var exportHref = Excel.tableToExcel(tableId, 'sheet name');
		   Data.post('CodManagement/GetCODExportData',{cond:$scope.filterData,limit:$scope.exportlimit}).then(function (results) {
			var $a = $("<a>");
			$a.attr("href",results.file);    
			$("body").append($a);
			$a.attr("download",results.file_name);  
			$a[0].click();
			$a.remove();
          });
            
        }
   
   
   $scope.getexcelpendList = function () { // ex: '#my-table' 

			//console.log($scope.exportlimit);  
        alert("Hi");
           //var exportHref = Excel.tableToExcel(tableId, 'sheet name');
		   Data.post('CodManagement/GetCODPendExportData',{cond:$scope.filterData,limit:$scope.exportlimit}).then(function (results) {
			var $a = $("<a>");
			$a.attr("href",results.file);     
			$("body").append($a);
			$a.attr("download",results.file_name);  
			$a[0].click();
			$a.remove();
          });
            
        }
});
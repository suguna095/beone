app.controller('reportCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams,Excel,$timeout) {
   
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.originlist=[]; 
	$scope.GetAccountlist=[];
	$scope.totalCount=0;
	$scope.routeArray={};
	$scope.editcustomerArray={};
	$scope.paymentinfoArr=[];
	$scope.statuslist=[]; 
	$scope.listData=[]; 
	$scope.onHolddata=[];
	$scope.CustDroplistArray=[];
	$scope.orderArray=[];
	 $scope.PaymentlistArray=[];
	 $scope.SearArr={};
		 angular.element(document).ready(function () {
    $(".select2").select2(); 
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    });
		
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
	
	
	 $scope.showTransactionReport = function (page_no,reset) {
		 //alert("Hi");
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.listData=[];
		  }
		   Data.post('Reports/allTransactionReport',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.listData.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};
		
		
		
	$scope.showOnHoldReport = function (page_no,reset) {
		// alert("Hi");
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.onHolddata=[];
		  }
		   Data.post('Reports/allOnHoldReport',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.onHolddata.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};
		
		
		
		$scope.checkarr={};
		//$scope.isAllSelected=false;
		$scope.isAll = false;
		 $scope.GetAllcheck = function() {
			 if($scope.isAll === false) { 
          
          angular.forEach($scope.checkarr, function(value){ 
	     value.checked = true;
		});
			 }
			 else
			 {
				// alert("ssssss");
				   angular.forEach($scope.checkarr, function(value){ 
	     value.checked = false;
		});
			 }
   
     }
	 $scope.ShowpageData="";
	$scope.GetReportFilterDataPage=function()
	{
		console.log($scope.checkarr);
		Data.post('Reports/report_download',{'filterdata':$scope.SearArr,'listdata':$scope.checkarr}).then(function (results) { 
				 //console.log(results);
				console.log(results);
				 $scope.ShowpageData=results.showarry;
				  $(popid).modal('hide');    
			 });
	
		
		
	}
   
   $scope.showSupplierDrop = function () {
			Data.post('Reports/getSupplierDrop').then(function (results) { 
				 //console.log(results);
				 $scope.supplierlist=results;
			 });
		 }; 
	$scope.ExcelTransacList={};
	 $scope.ShowTransactionExcel = function () {
			Data.post('Reports/allTransactionReportExcel').then(function (results) { 
				 console.log(results);
				 $scope.ExcelTransacList=results; 
			 });
		 }; 
	
		$scope.showOriginDrop = function () {
			Data.post('Reports/getOriginDrop').then(function (results) { 
				console.log(results);
				 $scope.originlist=results;
				 $scope.shelvearray=[];
				angular.forEach($scope.originlist, function(results){
					$scope.shelvearray.push(results.city);       
				});
				
				var input = document.getElementById("show_city_dropdown");
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;    
				console.log($scope.shelvearray); 
			 });
		 };	

	$scope.showStatusDrop = function () {
			Data.post('ShipmentManagement/getStatusDrop').then(function (results) { 
				// //console.log(results);
				 
				 $scope.statuslist=results;   
			 });
		 }; 
	$scope.showStaffDropData = function () {
		//alert("Hi");
       Data.post('Reports/ShowCustDrop').then(function (results) { 
			console.log(results);
			
		    $scope.CustDroplistArray=results;  
			
        });
	}

	$scope.PaymentReport = function (start_date,end_date) {
		//alert(end_date);
	Data.post('Reports/ShowPaymentDetails', {start_date:start_date,end_date:end_date}).then(function (results) {
			console.log(results);
			$scope.PaymentlistArray=results; 
			
        });
	};
	
			$scope.getallCustomerdata=function(company)
		{			
			Data.post('Reports/ShowCustomerDetails', {company:company}).then(function (results) {
			console.log(results);	  
			$scope.orderArray=results;
			
			//$scope.orderArray.company= $stateParams.company;

        });   
	};

	
		  $scope.exportToExcel = function (testTable_new) { // ex: '#my-table'

            var exportHref = Excel.tableToExcel(transaction_report, 'sheet name');
            $timeout(function () { location.href = exportHref; }, 100); // trigger download
        } 
	
		$scope.exportToExcelonHold_report = function (testTable_new) { // ex: '#my-table'

            var exportHref = Excel.tableToExcel(onHold_report, 'sheet name');
            $timeout(function () { location.href = exportHref; }, 100); // trigger download 
        }
	
		$scope.exportToExcelClientReport = function (testTable_new) { // ex: '#my-table'

            var exportHref = Excel.tableToExcel(tableId, 'sheet name');
            $timeout(function () { location.href = exportHref; }, 100); // trigger download 
        }
		
		$scope.exportToExcelPaymentReport = function (testTable_new) { // ex: '#my-table'
                   
                    
          
            $timeout(function () {
                  var exportHref = Excel.tableToExcel(paymentreport , 'sheet name');
                location.href = exportHref; }, 1000); // trigger download 
        }
		
	
	 $scope.AccountShow = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.GetAccountlist=[];
		  }
		   Data.post('CustomerManagement/ShowAccount',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
                          $scope.GetAccountlist.push(value);  

                        });
                    }
					else
					{
						$scope.nodata=true 
                    }
			});
		};
	

		$scope.GetShipmentpop=function(popid)
  {
	 
	  $(popid).modal('show');    
  }; 
   
   
		 
});
app.filter("month", function($locale) {
    return function(month) {
        return $locale.DATETIME_FORMATS.MONTH[month];
    }
})





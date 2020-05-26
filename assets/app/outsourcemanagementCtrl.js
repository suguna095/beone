app.controller('outsourcemanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.SupplierlistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
	$scope.supplierArray={};
	$scope.editsupplierArray={};
$scope.payDetailsArray=[];
$scope.payRateArray=[];
$scope.warninsArr=[];
$scope.scan={};
	$scope.scan.counterval=0;
 angular.element(document).ready(function () {
    
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    });
	
	 $scope.getSupplierlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.SupplierlistArray=[];
		  }
		   Data.post('OutsourceManagement/showSupplierlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.SupplierlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
		   $scope.GetSupplierdelete = function (id) {
				//alert (id); 
				Data.post('OutsourceManagement/get_delete_supplier', {id:id}).then(function (results) { 
					console.log(results);
						alert("Deleted Succssfully");
					$state.reload();
				  // $scope.edit_compidArray=results;
				});
			};
   
	
	$scope.Supplierform = function (add_supplier) {
		console.log(add_supplier);
        Data.post('OutsourceManagement/AddSupplier', {
            add_supplier: add_supplier
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Added Succssfully");
				$state.go('show_supplier');
				
            }
			else
			{
				alert("all field are required"); 
			//$scope.errormess=results.error;
			}
        });
    };
	
	
	
	
	
   
	$scope.supplierdatashow=function(custdata)
	{
		
		Data.post('OutsourceManagement/ShowEditsupplier', {supid:$stateParams.supid}).then(function (results) {
		//	console.log(results);
			$scope.editsupplierArray=results;
			$scope.editsupplierArray.supid= $stateParams.supid;

        });
	};
	//$scope.searchfield=[];
	$scope.PaymentDetailShow=function(page_no,reset,searchfield)
	{
		$scope.filterData.searchfield=searchfield;
		$scope.filterData.id=$stateParams.id;
		  if(reset==1)
		  {
		  $scope.payDetailsArray=[];
		  }
		   Data.post('OutsourceManagement/ShowPaymentDetail',$scope.filterData).then(function (results) {
		//Data.post('OutsourceManagement/ShowPaymentDetail', {id:$stateParams.id,$scope.filterData}).then(function (results) {
			console.log(results);
			$scope.payDetailsArray=results.result;
			$scope.payRateArray=results.supplier;
			//$scope.searchfield.invoice_year= Date('Y'); 

        });
	};
	
	
	
	

	$scope.SupplierEditupdate = function (edit_supplier) {
		//console.log(news);
        Data.post('OutsourceManagement/Updateeditsupplier', {
            edit_supplier: $scope.editsupplierArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully");
				$state.go('show_supplier'); 
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	$scope.ShowOutCityDrop=function()
	{
	 Data.post('OutsourceManagement/OutCityDrop').then(function (results) {
		//	console.log(results);
			$scope.OutCityArray=results;
	 });
	};
	
	$scope.ShowInvcSuppDrop=function()
	{
	 Data.post('OutsourceManagement/InvoiceSuppDrop').then(function (results) {
		//	console.log(results);
			$scope.InvcSuppArray=results; 
	 });
	};
	
	$scope.GetcheckCounter=function()
	{
	   $scope.scan.counterval=$scope.scan.counterval+1;  
	}
	
  



   $scope.GetCreateInvocieAwb = function () {

	Data.post('OutsourceManagement/genetate_invoice_supplier', $scope.scan).then(function (results) {
		
	  $scope.warninsArr=results.resultarr;
	   console.log($scope.warninsArr);
	});
};


   
   
   
   $scope.GetConfirm = function(invoice_no,service_pay_status)
	{
		//alert(drs_unique_id);
        Data.post('OutsourceManagement/getconfirmPayment', {invoice_no:invoice_no,service_pay_status:service_pay_status}).then(function (results) { 
		console.log(results);
		alert("Payment Updated Successfully");
		 $state.reload();
		    
        });
    };
	
	
});

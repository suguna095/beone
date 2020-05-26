app.controller('bulkmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
    $scope.codlistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
	$scope.routeArray={};
	$scope.editstaffArray={};
	$scope.payableinvoicelistArray=[];
	$scope.payablelistArray=[];
	$scope.editcodlistArray={};
	$scope.invoiceArray={};
	$scope.scan={};
	$scope.scan.counterval=0;  
	 $scope.scan.awb_no="";
	 $scope.SearArr={};
	 
	 
	 angular.element(document).ready(function () {
     $(".select2").select2();
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker3" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker4" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker5" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker6" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker7" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker8" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 
    });


	 $scope.getCODlist = function (page_no,reset) {
		// alert("sssss");
		$scope.SearArr.page_no=page_no;
		console.log($scope.SearArr);
		
		
		  if(reset==1)
		  {
		  $scope.codlistArray=[];
		  }
		   Data.post('BulkInvoiceManagement/showCodInvoiceData',$scope.SearArr).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.codlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
	$scope.GetStaffdelete = function (id) {
		//alert (id); 
        Data.post('StaffManagement/get_delete_staff', {id:id}).then(function (results) { 
			console.log(results);
		    if (results== 'true') {
				// Data.toast(results);
				
				$state.go('show_staff');	
				
            } 
          // $scope.edit_compidArray=results;
        });
    };
	
	$scope.Addstaffform = function (add_staff) {
		  //console.log(add_route);
        Data.post('StaffManagement/add_staff', {
            add_staff: add_staff
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.go('show_staff');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	$scope.Editstaffshow=function(custdata)
	{
		
		Data.post('StaffManagement/geteditstaffData', {staffid:$stateParams.staffid}).then(function (results) {
		//	console.log(results);
			$scope.editstaffArray=results;
			$scope.editstaffArray.staffid= $stateParams.staffid;

        });
	};
	
	$scope.EditStaffform = function (edit_staff) {
	    //console.log(edit_staff);  
        Data.post('StaffManagement/edit_staffform', {
            edit_staff: $scope.editstaffArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_staff');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };


     $scope.getPayableCODlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.payableinvoicelistArray=[];
		  }
		   Data.post('BulkInvoiceManagement/showPayableInvoiceData',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.payableinvoicelistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};


		 $scope.getPayablelist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.payablelistArray=[];
		  }
		   Data.post('BulkInvoiceManagement/showPayableData',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.payablelistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};


	$scope.Getpopoprncustdetais=function(pid,openid,type)
	{
	
	
	if(type=='one')
	 Data.post('BulkInvoiceManagement/ShowEditpay', {id:pid}).then(function (results) {
			console.log(results);
		   	$scope.editcodlistArray=results;
        });
		else
		{
			
		}
		  $(openid).modal('show');
	}
	$scope.invoiceArrayAll={};
	$scope.total_cod_amount=0;
	
	$scope.invoice_print=function(pid)
	{
		 console.log(pid);
		Data.post('BulkInvoiceManagement/ShowInvoice', {pid:$stateParams.printid}).then(function (results) {
			console.log(results);
			$scope.invoiceArrayAll=results.allarray;
			$scope.invoiceArray.pid= $stateParams.pid;
			$scope.invoiceArray=results.allarray[0];
			$scope.total_cod_amount=results.total_cod_amount;

        });
	};
	
	$scope.GetupdatePayment=function(arry)
	{
	
		Data.post('BulkInvoiceManagement/PaymentConfirmUpdaye', $scope.editcodlistArray).then(function (results) {
			console.log(results);
			  if (results== 'true') {
				// Data.toast(results);
				$window.location.reload();
				
            }
			else
			{
				alert("try again");
			//$scope.errormess=results.error;
			}
			

        });
	}
	
	$scope.payableinvoice_print=function(pid)
	{
		 console.log(pid);
		Data.post('BulkInvoiceManagement/Showpayableinvoice', {pid:$stateParams.pid}).then(function (results) {
			console.log(results);
			$scope.invoiceArray=results;
			$scope.invoiceArray.pid= $stateParams.pid;

        });
	};


	$scope.payablecod_print=function(pid)
	{
		 console.log(pid);
		Data.post('BulkInvoiceManagement/ShowpayableCODinvoice', {pid:$stateParams.pid}).then(function (results) {
			console.log(results);
			$scope.invoiceArray=results;
			$scope.invoiceArray.pid= $stateParams.pid;

        });
	};


$scope.CustomerDropdata={};
   $scope.GetcustomerData=function()
   {
	   //alert("sssss");
	   Data.post('BulkInvoiceManagement/GetcustomerShowdata').then(function (results) {
			console.log(results);
			
			$scope.CustomerDropdata=results;
		

        });
   }
   $scope.staffDropdata={};
   $scope.GetstaffDropData=function()
   {
	   //alert("sssss");
	   Data.post('BulkInvoiceManagement/GetstaffDropData').then(function (results) {
			console.log(results);
			
			$scope.staffDropdata=results;
		

        });
   }
   
   $scope.GetcheckCounter=function()
   {
	  $scope.scan.counterval=$scope.scan.counterval+1;
   }
  $scope.WarninsArr={};
   $scope.GetCreateInvocieAwb=function()
   {
	  // alert("sss");
	   if($scope.scan.awb_no!="")
	   {
		  // $scope.WarninsArr.empty="";
		    Data.post('BulkInvoiceManagement/GetCreateBultINvoiceData',$scope.scan).then(function (results) {
			console.log(results);
			//$scope.CustomerDropdata=results;
			$scope.WarninsArr=results.returnArr;
        });
		   
	   }
	   else
	   {
		 //  alert("sssss");
	   $scope.WarninsArr.empty="Please Scan Awb No.";
	   }
	   
   }
	$scope.payableInvoice_update = function (custdata) {
		
        Data.post('BulkInvoiceManagement/payableInvoice_update', $scope.editcodlistArray).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$window.location.reload();
				
            }
			else
			{
				alert("try again");
			//$scope.errormess=results.error;
			}
        });
    };


});

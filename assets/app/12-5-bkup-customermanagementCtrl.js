app.controller('customermanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams,$sce) {
   
   $scope.CustomerlistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
		$scope.originlist=[]; 
	 $scope.GetAccountlist=[];
	 $scope.totalCount=0;
	$scope.routeArray={};
	$scope.editcustomerArray={};
	$scope.paymentinfoArr=[];
	$scope.CountryData={};
	 $scope.zoneList={};
	 $scope.serviceList={};
	 $scope.protypeArr={};
	$scope.orderArray={};
	$scope.Bookdetlist=[]; 
		$scope.statuslist=[]; 
		 angular.element(document).ready(function () {
    
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
	 $scope.getCustomerlist = function (page_no,reset) {
		  disableScreen(1);
		 $scope.loadershow=true; 
		$scope.filterData.page_no=page_no; 
		  if(reset==1)
		  {
		  $scope.CustomerlistArray=[];
		  }
		   Data.post('CustomerManagement/showCustomerlist',$scope.filterData).then(function (results) {
			    disableScreen(0);
		 $scope.loadershow=false; 
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
                          $scope.CustomerlistArray.push(value);

                        });
                    }
					else
					{
						$scope.nodata=true 
                    }
			});
		};
   
   $scope.showStatusDrop = function () {
			Data.post('ShipmentManagement/getStatusDrop').then(function (results) { 
				// //console.log(results);
				 
				 $scope.statuslist=results;
			 });
		 }; 
		 
		 $scope.ExcelCustList={};
		 $scope.ShowcustomerExcel = function () {
			Data.post('CustomerManagement/ShowExcelDatalist').then(function (results) { 
				// //console.log(results);
				 
				 $scope.ExcelCustList=results;
			 });
		 };  
		 
		 
		 
	 $scope.ShowBookDetails = function (page_no,reset) {
		 //alert(cusid);
		// $scope.page_no=page_no; 
		   if(reset==1)
		  {
		  $scope.Bookdetlist=[];
		  }
			Data.post('CustomerManagement/GetBookingDetaillist',{cusid:$stateParams.cusid,page_no:page_no}).then(function (results) { 
				console.log(results); 
				 
				 //$scope.Bookdetlist=results;
				 $scope.Bookdetlist_new=results;
				  if(results.length > 0)
				 {
                        angular.forEach(results,function(value) 
						{
                          $scope.Bookdetlist.push(value);

                        });
                    }
			$scope.Bookdetlist.cusid= $stateParams.cusid;
			 });
		 };  
		 
	/*$scope.gettotalofd=function(custdata)
	{   
		//alert("HIii");
		Data.post('CustomerManagement/ShowtotalshelveDetails', {shelv_no:$stateParams.shelv_no}).then(function (results) {
			console.log(results);
			$scope.totalShelvelist=results.result;

		
        });
	};*/
	

	
	$scope.GetCustomerdelete = function (id) {
		//alert (id);   
        Data.post('CustomerManagement/get_delete_customer', {id:id}).then(function (results) { 
			console.log(results);
		    $state.reload(); 
        }); 
    };
	
	$scope.Customerform = function (customerArray) {
		 // console.log(customerArray);
        Data.post('CustomerManagement/AddCustomer', {
            customerArray: customerArray
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Added Succeessfully");
				$state.go('show_customer');	 
				
            }
			else if (results== 'false'){
				
					alert("all field are required");  
			}
				
			else{
				alert("Email Id is Already Exist");
			
			}
        });
    };
	
	
	
		$scope.weightrangeform = function (customerArray) {
		  console.log(customerArray);
       /* Data.post('CustomerManagement/AddCustomer', {
            customerArray: customerArray
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.go('show_customer');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        }); */
    };
	
	
	
	
	$scope.EditCustomershow=function(custdata)
	{
		
		Data.post('CustomerManagement/ShowEditcustomer', {cusid:$stateParams.cusid}).then(function (results) {
		console.log(results);
			$scope.editcustomerArray=results;
			$scope.editcustomerArray.cusid= $stateParams.cusid;
			$scope.editcustomerArray.city=$scope.editcustomerArray.cityname;   

        });
	};
	
	
	$scope.filterData.search_year=2020;
	$scope.paymentInfoshow=function(searchtype) 
	{		console.log($scope.filterData);
	if(searchtype==1)
	$scope.paymentinfo=[];
	    $scope.filterData.cusid=$stateParams.cusid;
	      disableScreen(1);
		 $scope.loadershow=true; 
		Data.post('CustomerManagement/ShowPaymentInfo', $scope.filterData).then(function (results) {
		console.log(results);
		disableScreen(0);
		 $scope.loadershow=false;
			$scope.paymentinfo=results;
			//$scope.editcustomerArray.cusid= $stateParams.cusid;

        });
	};
	$scope.invoice_month_year=$stateParams.invoice_month_year;
	
	$scope.customerpaymentshow=function()
	{		//alert(filterData);
	 $scope.filterData.cusid=$stateParams.cusid;
	 $scope.filterData.invoice_month_year=$stateParams.invoice_month_year;
	
		Data.post('CustomerManagement/ShowCustomerPaymentInfo',$scope.filterData).then(function (results) {
		console.log(results);
			$scope.paymentinfoArr=results;
			//$scope.editcustomerArray.cusid= $stateParams.cusid;

        });
	};
	$scope.paymentPopArr={};
	 $scope.GetEmailSendPopup=function(invoice_id,popid)
  {
	 Data.post('CustomerManagement/ShowSendMailData', {invoice_id:invoice_id}).then(function (results) {
			console.log(results);
			$scope.paymentPopArr=results; 
			//$scope.MailDataArray.id= custdata.id ;
        });  
	  $(popid).modal('show');
  };
  
  
   $scope.invoice_paid_cod_form_id_pop=function(invoice_id,popid)
  {
	 Data.post('CustomerManagement/ShowSendMailData', {invoice_id:invoice_id}).then(function (results) {
			console.log(results);
			$scope.paymentPopArr=results; 
			//$scope.MailDataArray.id= custdata.id ;
        });  
	  $('#invoice_paid_cod_form_id').modal('show');
  };
   
   $scope.GetupdateReceive_Payment=function(dataArr)
   {
	  // console.log(dataArr);
	  Data.post('CustomerManagement/GetrecivedPaymentUpdate', dataArr).then(function (results) {
			console.log(results);
			alert("successfully updated");
			$('#exampleModalForms').modal('hide');
			//$scope.paymentPopArr=results; 
			//$scope.MailDataArray.id= custdata.id ;
        });    
   }
   

  


	$scope.EditCustomerform = function (edit_customer) {
	   // console.log(edit_customer);  
       Data.post('CustomerManagement/UpdateEditCustomer', {
            edit_customer: $scope.editcustomerArray  
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
					alert("Updated Succeessfully");
				$state.go('show_customer');
				
            }
			else if (results== 'false'){
				
					alert("all field are required");  
			}
				
			else{
				alert("Email Id is Already Exist");
			
			}
        });
    };
	
	$scope.Templateform = function (add_template,id) {
	   // console.log(add_template);  
        Data.post('CustomerManagement/addTemplate', { 
            id: $scope.tempArray   
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_customer');
				
            }
			else
			{
				alert("all field are required");  
			//$scope.errormess=results.error;
			}
        });
		
    };
	
	
	
	$scope.Getpopoprncustdetais=function(cust_id,openid,type)
	{
	// console.log(cust_id);
	// console.log(openid);
	
	if(type=='one')
	 Data.post('CustomerManagement/ShowEditcustomer', {cusid:cust_id}).then(function (results) {
			console.log(results);
		   	$scope.editcustomerArray=results;
        });
		else
		{
			
		}
		  $(openid).modal('show');
	}
	
	
	
	 $scope.AccountShow = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.GetAccountlist=[];
		  }
		   Data.post('CustomerManagement/ShowAccount',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
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
		
		$scope.ShowactiveStatus = function (id,status) {
		
        Data.post('CustomerManagement/GetstaffstatusUpdate', {id:id,status:status}).then(function (results) { 
			console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };
	$scope.isAll = false;
        $scope.selectAll = function() {
			//alert("hii");
            if($scope.isAll === false) {
                angular.forEach($scope.CustomerlistArray, function(data){
                    data.checked = true;
                }); 
                $scope.isAll = true;
            } else {
                angular.forEach($scope.CustomerlistArray, function(data){
                    data.checked = false;
                });
                $scope.isAll = false;
            }
        };
	$scope.showOriginDrop = function () {
			Data.post('CustomerManagement/getOriginDrop').then(function (results) { 
				 console.log(results);
				 
				 $scope.originlist=results;
				 
				 $scope.shelvearray=[];
				angular.forEach($scope.originlist, function(results){ 
					$scope.shelvearray.push(results.state);       
				});
				
				var input = document.getElementById("show_city_dropdown");
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;
				console.log($scope.shelvearray);
			 });
		 }; 
		 
		 
		 $scope.showRate = function (orderArray) {
        console.log($scope.orderArray);
        if($scope.orderArray.zone_id==undefined)
        {
            console.log('xxxx');
        $scope.error.zone_id=true;   
        }
        else
        {
        $scope.error.zone_id=false; }
        
        if($scope.orderArray.sel_service_id_new==undefined)
        {
        $scope.error.sel_service_id_new=true;   
        }
         else
        {
        $scope.error.sel_service_id_new=false; }
        if($scope.orderArray.product_type==undefined)
        {
        $scope.error.product_type=true;   
        }
         else
        {
        $scope.error.product_type=false; }
        console.log($scope.error);
         if($scope.error.product_type==false && $scope.error.zone_id==false && $scope.error.sel_service_id_new==false) 
         {
        console.log($stateParams);
        /*$scope.orderArray['cust_id']=$stateParams.cust_id;
			Data.post('CouriersManagement/showRate',$scope.orderArray).then(function (results) { 
				 console.log(results);
				 
				 $scope.rateList=JSON.parse( JSON.stringify(results));
				 
				
			   // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
			 });*/
        }
        else{
        
        }
		 };
	function Getloginalerttrue(title,mess,type,icon)
		 {  
				$.alert({
					title: title,
					icon: icon,
                    type: type,
					content: mess,
					buttons: {
						close: function () {
							 $state.go('show_customer');
						},
					}
				});
		 }
	//$scope.
	  $scope.Warningshow={};
	 $scope.upload = function(value){
		  disableScreen(1);
		 $scope.loadershow=true; 
		  var filedata=new FormData();
		  angular.forEach($scope.uploadfiles,function(file){
		  filedata.append('file',file);
		 });
//console.log(filedata);
	   $http({
	  method: 'post',
	  url: 'CustomerManagement/customerImportsrates',
	  data: filedata,
	  headers: {'Content-Type': undefined},
	 }).then(function(response) { 
	  console.log(response);
	   disableScreen(0);
	   $scope.loadershow=false; 
	  
	  
	  if(response.data!='null')
	  {		  	
	  $scope.alretData="";
	  angular.forEach(response.data.invalidrpows,function(value) 
		{
			 $scope.alretData=$scope.alretData+" "+value;
			
		});
		angular.forEach(response.data.validrows,function(value1) 
		{
			 $scope.alretData=$scope.alretData+" "+value1;
			
		});
		Getloginalerttrue("Alert",$scope.alretData,"orange","fa fa-warning");   
	
  }
  else
  Getloginalerttrue("Error",'please select file',"orange","fa fa-warning");    
  
 });
};
$scope.ResultCheckArr=false;
$scope.RatesSetArr="";
$scope.WeightSetArr={};
$scope.weight_details={};
$scope.zone_list={};
$scope.ZopeRateUpdateArr={};
$scope.ShowRatesResultData=function()
{
	$scope.orderArray.cust_id=$stateParams.uniqueid;
	 console.log($scope.orderArray);
	//alert($stateParams.uniqueid);
	 disableScreen(1);
	  $scope.loadershow=true; 
	   Data.post('CustomerManagement/Getzone_price_setData',$scope.orderArray).then(function (results) { 
	   $scope.ResultCheckArr=true;
	   disableScreen(0);
	  $scope.loadershow=false; 
	  //console.log(results);
	 // $scope.RatesSetArr=$sce.trustAsHtml(results.resultArr);
	// $scope.weight_details=results.weight_details;
	// $scope.zone_list=results.zone_list;
	$scope.RatesSetArr=results;
	 
	  });
}

 $scope.GetpriceUpdateForPage=function(counter,type,sr,er)
   {
	   if(type=='PC')
	   {
	    document.getElementById('pricefiledID1'+counter+""+sr+""+er).style.display="block";
		 document.getElementById('pricefiledID'+counter+""+sr+""+er).style.display="none";
		 document.getElementById('pricefiledID2'+counter+""+sr+""+er).style.display="block";
	   }
	   else if(type=='Cfees')
	   {
		    document.getElementById('rcodfiledID'+counter).style.display="none";
		 document.getElementById('rcodfiledID1'+counter).style.display="block";
		 document.getElementById('rcodfiledID2'+counter).style.display="block";
		 }
		 else
		 {
			 document.getElementById('rfeesfiledID'+counter).style.display="none";
		 document.getElementById('rfeesfiledID1'+counter).style.display="block";
		 document.getElementById('rfeesfiledID2'+counter).style.display="block";
		 }
	   
   }
   $scope.GetupdateZoneRatesData=function(id,counter,val,field,start_range,end_range,to_zone)
   {
	   
	   $scope.orderArray.id=id;
	   $scope.orderArray.counter=counter;
	   $scope.orderArray.value=val;
	    $scope.orderArray.field=field;
		 $scope.orderArray.start_range=start_range;
		  $scope.orderArray.end_range=end_range;
		  $scope.orderArray.to_zone=id;
	 	//console.log( $scope.orderArray);
		  disableScreen(1);
	  $scope.loadershow=true; 
	  Data.post('CustomerManagement/GetUpdateCustomerRateByZones',$scope.orderArray).then(function (results) { 
	   disableScreen(0);
	   //	console.log(results);
	  $scope.loadershow=false; 
		 if(field=='price')
	   {
	    document.getElementById('pricefiledID1'+counter+""+start_range+""+end_range).style.display="none";
		 document.getElementById('pricefiledID'+counter+""+start_range+""+end_range).style.display="block";
		 document.getElementById('pricefiledID2'+counter+""+start_range+""+end_range).style.display="none";
	   }
	   else if(field=='cod_fees')
	   {
		    document.getElementById('rcodfiledID'+counter).style.display="block";
		 document.getElementById('rcodfiledID1'+counter).style.display="none";
		 document.getElementById('rcodfiledID2'+counter).style.display="none";
		 }
		 else
		 {
			 document.getElementById('rfeesfiledID'+counter).style.display="block";
		 document.getElementById('rfeesfiledID1'+counter).style.display="none";
		 document.getElementById('rfeesfiledID2'+counter).style.display="none";
		 }
		  });
   }



$scope.GetweightRangeDetails=function()
{
	  disableScreen(1);
	  $scope.loadershow=true; 
	  Data.post('CustomerManagement/GetweightRangeDetailsPage').then(function (results) { 
	   disableScreen(0);
	  $scope.loadershow=false; 
	  });
}


$scope.weightrangeUpdate=function()
{
	
	 disableScreen(1);
	  $scope.loadershow=true; 
	  Data.post('CustomerManagement/weightrangeUpdateData',$scope.RangeArr).then(function (results) { 
	   disableScreen(0);
	  $scope.loadershow=false; 
	  console.log(results);
	  if(results>0)
	  {
		   Getloginalerttrue("Alert",'Successfully Added',"orange","fa fa-success"); 
	  }
	  else
	  Getloginalerttrue("Alert",'try again',"orange","fa fa-warning"); 
	 });
	
}


  $scope.showZoneDrop = function () {
			Data.post('CustomerManagement/showZoneDrop').then(function (results) { 
				 console.log(results);
				 
				 $scope.zoneList=results;
				 
				
			   // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
			 });
		 };
		 
  $scope.showserviceDropData = function () {
			Data.post('CustomerManagement/showserviceDrop').then(function (results) { 
				 console.log(results);
				 
				 $scope.serviceList=results;
				 
				
			   // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
			 });
		 };
		 
		  $scope.ShowProductTypeDropData = function () {
			Data.post('CustomerManagement/ShowproductTypeDrop').then(function (results) { 
				 console.log(results);
				 
				 $scope.protypeArr=results;
				 
				
			   // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
			 });
		 };
   
   $scope.RangeArr = [{start_range: '0',end_range:'10','cust_id':$stateParams.uniqueid}];
     $scope.addNewWeightRange = function() {
    var newItemNo = $scope.RangeArr.length+1;
	var checklastVal=$scope.RangeArr.length-1;
	//console.log($scope.RangeArr);
	//console.log(checklastVal);
    $scope.RangeArr.push({'start_range':$scope.RangeArr[checklastVal].end_range,'end_range':'','cust_id':$stateParams.uniqueid});
  };
    
 $scope.GetCountryDropshow=function()
	{
	Data.post('InventoryManagement/GetCountryDropshowShow').then(function (results) {
			console.log(results);
			$scope.CountryData=results;
	 });	
	}
		 
});
app.filter("month", function($locale) {
    return function(month) {
        return $locale.DATETIME_FORMATS.MONTH[month];
    }
})

app.controller('warehouseCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams,$interval) {
    //initially set those objects to null to avoid undefined error
    $scope.InventoryListArray=[];
	$scope.filterData = {};
	$scope.ScanShipmentArray=[];
	$scope.HoldShipmentArray=[];
	$scope.ScheduleShipmentArray=[];
	 $scope.BoundShipmentArray=[];
	//alert("ssssss");
	$scope.IsVisible = true;
	$scope.IsVisible1 = false;
	$scope.myvalue = false;
$scope.from_date='';
	$scope.to_date='';
	$scope.shipments=[];
	$scope.awbArray=[];
	$scope.shelve=null;
	$scope.Message='';
	$scope.warning=''
	$scope.complited=[];

 angular.element(document).ready(function () {
   
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    });
	$scope.Scanschedule_shipment=function(){
		console.log($scope.awbArray);
		console.log($scope.awbArray.indexOf($scope.slip_no));
		$scope.Message='';
		$scope.warning=''
		
		if($scope.awbArray.indexOf($scope.slip_no) >=0 )
		{
			$scope.warning='Shipment Already scanned';
			var sound = document.getElementById("audio");
         	 sound.play();
			console.log('xxxxxxxxxxxxxxxxxxxxxx');
			}
		
		if ( $scope.slip_no!=null) 
		{
  			$scope.awbArray.push($scope.slip_no.toUpperCase().trim());;

		 
		Data.post('WarehouseManagement/scanScheduleData',{slip_no:$scope.slip_no,from_date:$scope.from_date,to_date:$scope.to_date,shelve:$scope.shelve}).then(function (response) {
		$scope.responseData=response;
		if($scope.responseData.slip_no!='0'){
		
			
				responsiveVoice.speak("Scheduled")
				$scope.Message='Scheduled rout code: '+$scope.responseData.messanger_code +' courier: '+$scope.responseData.messanger_name;
				$scope.printToCart($scope.responseData.print_url);
			
	
		$scope.shipments.push(response);
		console.log($scope.shipments);
		}
		else
		{
				$scope.warning='Shipmnent Not Available!';
				}
	})
		
		$scope.slip_no=null;
		//$scope.loading = false;
		// onLoadWatingPoupupClose();
		}
		else
		{
			responsiveVoice.speak("AWB empty")
		
			$scope.warning='AWB empty!';
			$scope.slip_no=null;
			
			}
			$('#scan_awb').focus();
		}
		
		 $scope.printToCart = function(print_url) {
      // $window.open("//www.tamex.co/", '', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
	    var innerContents = document.getElementById('test_print').innerHTML;
        var popupWinindow =  $window.open('//www.tamco.sa/printschedule/'+print_url+'', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
    
   // WindowObject.close();
	   setTimeout(function () { popupWinindow.close();}, 3000);
		 
	
      }
	  
	  $scope.securitycheckScan=function(){
		console.log($scope.awbArray);
		console.log($scope.awbArray.indexOf($scope.slip_no));
		$scope.Message='';
		$scope.warning=''
		
		
		
		
			
		
		if ( $scope.drs_id!=null) 
		{	
		
		if ( $scope.slip_no!=null) 
		{
  			$scope.awbArray.push($scope.slip_no.toUpperCase().trim());;
console.log($scope.slip_no);
		 //
		 Data.post('WarehouseManagement/securityCheckData',{slip_no:$scope.slip_no,scanned:$scope.awbArray,drs_id:$scope.drs_id}).then(function (response) {
		$scope.responseData=response;
		console.log($scope.responseData.length);
		if($scope.responseData.slip_no!=null){
			if($scope.responseData.scanned<=$scope.responseData.pieces)
			{
		
		if($scope.responseData.scanned==$scope.responseData.pieces)
		{
			$scope.complited.push(response);
			$scope.Message='Completed!';
			responsiveVoice.speak($scope.Message)
// 			$.each( $scope.shipments, function(i, el){
//     if (this.slip_no == $scope.responseData.slip_no){
//         $scope.shipments.splice(i, 1);
//     }
// });
				
			$.each( $scope.shipments, function(i, el){
    if (this.slip_no == $scope.responseData.slip_no){
        $scope.shipments.splice(i, 1);
    }
});
            $scope.shipments.push(response);		
			
		}
		else
		{
			$scope.warning='Short!';
			responsiveVoice.speak($scope.warning);
			$.each( $scope.shipments, function(i, el){
    if (this.slip_no == $scope.responseData.slip_no){
        $scope.shipments.splice(i, 1);
    }
});
            $scope.shipments.push(response);
		    console.log($scope.shipments);
			}
		    
			}
		else
		{
			$scope.warning='All Parts Scanned for '+$scope.responseData.slip_no;
			responsiveVoice.speak($scope.warning);
			}
		}
		else
		{
				$scope.warning='Shipment Not Available!';
				responsiveVoice.speak($scope.warning);
				}
	})
		
		$scope.slip_no=null;
		//$scope.loading = false;
		// onLoadWatingPoupupClose();
		}
		else
		{
			responsiveVoice.speak("AWB empty")
		
			$scope.warning='AWB empty!';
			$scope.slip_no=null;
			
			}
		}
else
{
	responsiveVoice.speak("Scan DRS id first")
		
			$scope.warning='Scan DRS id first!';
			//$scope.slip_no=null;
	
	}
			$('#scan_awb').focus();
		}
		
		
		$scope.create_menifest=function(){
		
		console.log($scope.complited);
		// 
		 Data.post('WarehouseManagement/GetverifyCreateManifest',{slip_no:$scope.slip_no,scanned:$scope.shipments}).then(function (response) {
		$scope.Message='Security Check complited';
		responsiveVoice.speak($scope.Message)		
		//onLoadWatingPoupupClose();
		})
		}
	    $scope.OnholdScanShipemt=function(){
		console.log($scope.awbArray);
		console.log($scope.awbArray.indexOf($scope.slip_no));
		$scope.Message='';
		$scope.warning=''
		if($scope.from_date==null)
		{
			$scope.warning='Select from date';
		responsiveVoice.speak("Select from date");
			}
			else if ($scope.to_date==null)
			{
				$scope.warning='Select to date';
		
		responsiveVoice.speak("Select to date");
				}
				else
				{
				
		if($scope.awbArray.indexOf($scope.slip_no) >=0 )
		{
			$scope.warning='Shipment Already scanned';
			var sound = document.getElementById("audio");
         	 sound.play();
			console.log('xxxxxxxxxxxxxxxxxxxxxx');
			}
			else
			{
				$scope.awbArray.push($scope.slip_no.toUpperCase().trim());;
				}
	
		if ( $scope.slip_no!=null) 
		{
		 Data.post('WarehouseManagement/GetOnHoldShipmentDataUpdate',{slip_no:$scope.slip_no,from_date:$scope.from_date,to_date:$scope.to_date}).then(function (response) {
		$scope.responseData=response;
		
		//console.log('xxxxxx'+$scope.responseData.length);
		if($scope.responseData.slip_no!='0'){
		if($scope.awbArray.indexOf($scope.slip_no) >0 )
		{
			if($scope.responseData.onHold_Confirm=='YES'){
			console.log('sssssssssssssssss');
			responsiveVoice.speak("On Hold");
			$scope.warning='On Hold';
			//$scope.shipments.push(response);
			}
		}
		else
		{
			if($scope.responseData.onHold_Confirm=='YES'){
			responsiveVoice.speak("On Hold");
			$scope.warning='On Hold';
			}
			$scope.shipments.push(response);
			
			}
		
		}
		else
		{
				$scope.warning='Shipmnent Not Available!';
				}
	})
		
		$scope.slip_no=null;
		//$scope.loading = false;
		// onLoadWatingPoupupClose();
		}
		else
		{
			responsiveVoice.speak("AWB empty")
		
			$scope.warning='AWB empty!';
			$scope.slip_no=null;
			
			}
			$('#scan_awb').focus();
		}
		
	};
	
	
	$scope.inboundShipmentScan=function(){
		console.log($scope.awbArray);
		console.log($scope.awbArray.indexOf($scope.slip_no));
		$scope.Message='';
		$scope.warning=''
		if($scope.from_date==null)
		{
			$scope.warning='Select from date';
		responsiveVoice.speak("Select from date");
			}
			else if ($scope.to_date==null)
			{
				$scope.warning='Select to date';
		
		responsiveVoice.speak("Select to date");
				}
				else
				{
				
		if($scope.awbArray.indexOf($scope.slip_no) >=0 )
		{
			$scope.warning='Shipment Already scanned';
			var sound = document.getElementById("audio");
         	 sound.play();
			console.log('xxxxxxxxxxxxxxxxxxxxxx');
			}
	
		if ( $scope.slip_no!=null) 
		{
  			

		 
		 Data.post('WarehouseManagement/scanInboundShipment',{slip_no:$scope.slip_no,from_date:$scope.from_date,to_date:$scope.to_date}).then(function (response) {
		$scope.responseData=response;
		
		console.log('xxxxxx'+$scope.responseData);
		if($scope.responseData.slip_no!='0'){
		if($scope.awbArray.indexOf($scope.slip_no) >0 )
		{ 
			
		
			//$scope.shipments.push(response);
		}
		else
		{
			$scope.shipments.push(response);
			$scope.awbArray.push($scope.slip_no);
			}
			if($scope.responseData.destination!='') 
			{	
			responsiveVoice.speak($scope.responseData.destination,  "UK English Female", {pitch: 1});
			$scope.warning=$scope.responseData.destination;	
			}
		
		}
		else
		{
			$scope.warning='Shipment Not Available!';
			responsiveVoice.speak($scope.warning,  "UK English Female", {pitch: 1});
				
				}
	})
		
		$scope.slip_no=null;
		//$scope.loading = false;
		// onLoadWatingPoupupClose();
		}
		else
		{
			responsiveVoice.speak("AWB empty")
		
			$scope.warning='AWB empty!';
			$scope.slip_no=null;
			
			}
			$('#scan_awb').focus();
		}
		
	}
		$scope.generateReport=function(report_type){
		console.log($scope.awbArray);
		 
		 Data.post('WarehouseManagement/GetAddReportData',{slip_no:$scope.awbArray,report_type:report_type}).then(function (response) {
		
		responsiveVoice.speak("Report generetated successfully")
		
			$scope.warning='Report generetated successfully!';
		$scope.awbArray=[];
	})
	
}
 $scope.getInventoryreport = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.InventoryListArray=[];
		  }
		   console.log($scope.filterData);
		   Data.post('WarehouseManagement/showinventorylist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)  
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.InventoryListArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};

       $scope.CityDropList={};
	   $scope.ShowCityDropdata=function()
	   {
		 Data.post('WarehouseManagement/GetCityDrop').then(function (results) {
			 console.log(results);
			$scope.CityDropList=results;
			$scope.shelvearray=[];
				angular.forEach($scope.CityDropList, function(results){
					$scope.shelvearray.push(results.city);       
				});
				
				var input = document.getElementById("show_city_dropdown");
				var awesomplete = new Awesomplete(input); 

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;
				console.log($scope.shelvearray);
		});
	}
	   
	   
	   $scope.HubDropList={};
	   $scope.ShowHubDropdata=function()
	   {
		 Data.post('WarehouseManagement/GetCityDrop').then(function (results) {
			 console.log(results);
			$scope.HubDropList=results;
			$scope.shelvearrays=[];
				angular.forEach($scope.HubDropList, function(results){
					$scope.shelvearrays.push(results.city);        
				});
				
				var input = document.getElementById("show_city_dropdownss");
				var awesomplete = new Awesomplete(input); 

				/* ...more code... */

				awesomplete.list =$scope.shelvearrays;
				console.log($scope.shelvearrays); 
		});
	}
	   
		 $scope.viewHoldShipment = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.HoldShipmentArray=[];
		  }
		   Data.post('WarehouseManagement/showHoldShipmentlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				
				if(results.count>0){
					
					document.getElementById("fname_error1").innerHTML="Report Generated!";
					
				}else{
					
					document.getElementById("fname_error1").innerHTML="Shipmnent Not Available!";
				}
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
							
                          $scope.HoldShipmentArray.push(value);
						  
                        });
                    }
					else
					{$scope.nodata=true 
                    }
			});
		};
		
		 
		  $scope.viewBoundShipment = function (page_no,reset) {
			$scope.filterData.page_no=page_no;
			  if(reset==1)
			  {
			  $scope.BoundShipmentArray=[];
			  }
			   Data.post('WarehouseManagement/showBoundShipmentlist',$scope.filterData).then(function (results) {
				   $scope.totalCount=results.count;
					console.log(results);
					if(results.count>0){
					
					document.getElementById("fname_error3").innerHTML="Report Generated!";
					
				}else{
					
					document.getElementById("fname_error3").innerHTML="Shipmnent Not Available!";
				}
				
					 if(results.result.length > 0)
					 {
	                        angular.forEach(results.result,function(value)
							{
								 $scope.myvalue = true;  
	                          $scope.BoundShipmentArray.push(value);

	                        });
	                    }
						else
						{$scope.nodata=true 
	                    }
				});
		};

		 $scope.viewScheduleShipment = function (page_no,reset) {
			$scope.filterData.page_no=page_no;
			  if(reset==1)
			  {
			  $scope.ScheduleShipmentArray=[];
			  }
			   Data.post('WarehouseManagement/showScheduleShipmentlist',$scope.filterData).then(function (results) {
				   $scope.totalCount=results.count;
					console.log(results);
					if(results.count>0){
					
					document.getElementById("fname_error2").innerHTML="Report Generated!";
					
				}else{
					
					document.getElementById("fname_error2").innerHTML="Shipmnent Not Available!";
				}
					 if(results.result.length > 0)
					 {
	                        angular.forEach(results.result,function(value)
							{
	                          $scope.ScheduleShipmentArray.push(value);

	                        });
	                    }
						else
						{$scope.nodata=true 
	                    }
				});
		};

		
		
		
		
		
		
	
		$scope.Customerform = function (filterData) {
		  console.log(filterData);
        Data.post('WarehouseManagement/AddCustomer', {
            filterData: filterData
        }).then(function (results) {
			console.log(results);  
		   
            if (results=='true') {
				// Data.toast(results);
				$state.go('scan_shipment');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	$scope.warehouse_manage=function()
	{
		 Data.post('WarehouseManagement/warehouse_manage').then(function (results) {
			 console.log(results);
			 var shelvedata= localStorage.getItem('shelvedata');
	       // console.log(shelvedata);
			var string =JSON.stringify(results)
			  localStorage.setItem('shelvedata', null);
			 localStorage.setItem('shelvedata', JSON.stringify(string));
		});
	}
		
	$scope.scan_awb=function(){
		$('#scan_awb').focus();
		}
	
	
	    $scope.shelvedata= JSON.parse(localStorage.getItem('shelvedata'));
		console.log($scope.shelvedata);
       $scope.doSomething=function(){
		console.log($scope.awbArray);
		
		console.log($scope.awbArray.indexOf($scope.slip_no));
		$scope.Message='';
		$scope.warning=''
		
		if($scope.awbArray.indexOf($scope.slip_no) >=0 )
		{
			$scope.warning='Shipment Already scanned';
			var sound = document.getElementById("audio");
         	 sound.play();
		
			}
			if ($scope.slip_no!=null) {
				
				console.log($scope.slip_no);
				console.log("sssssssssssss");
				var shelveData=[];
				console.log(angular.fromJson(JSON.parse(localStorage.getItem('shelvedata'))));
				console.log("tttttttttttt");
				$scope.parsedData=JSON.parse(localStorage.getItem('shelvedata'));
				$scope.arraymaking=angular.fromJson($scope.parsedData);
				shelveData=$scope.arraymaking;
   				console.log('qwwqeqwe'+shelveData.includes($scope.slip_no));
   				
				 if(shelveData.includes($scope.slip_no) ==true )
				 {
					$scope.shelve= $scope.slip_no; 
					$scope.slip_no=null; 
				 }
				
			
		if ( $scope.slip_no!=null) {		 
		if($scope.shelve!=null )
		{
  			$scope.awbArray.push($scope.slip_no.toUpperCase().trim());
	     console.log($scope.slip_no+'//'+$scope.shelve);
		 
		  Data.post('WarehouseManagement/GetshipmentScanData', {slip_no:$scope.slip_no,shelve:$scope.shelve}).then(function (response) {
			  console.log(response);
		$scope.responseData=response;
		if($scope.responseData.slip_no!=''){
			if($scope.responseData.onHold_Confirm=='YES'){
		if($scope.responseData.refused=='YES')
		{
			responsiveVoice.speak("On Hold");
			$scope.warning='On Hold';
		}
		}else
		{
			if($scope.responseData.schedule_status_for_tommorow=='Yes' )
			{
				responsiveVoice.speak("Scheduled")
				$scope.Message='Scheduled rout code: '+$scope.responseData.messanger_code +' courier: '+$scope.responseData.messanger_name;
				$scope.printToCart($scope.responseData.print_url);
			}
		}
		$scope.shipments.push(response);
		console.log($scope.shipments);
		}
		else
		{
			$scope.warning='Shipmnent Not Available!';
		}
	})
		
		$scope.slip_no=null;
		//$scope.loading = false;
		// onLoadWatingPoupupClose();
		}
		else
		
		{
			responsiveVoice.speak("Scan shelve First")
				//$scope.Message='Scheduled';
			$scope.warning='Scan Shelve First!';
			$scope.slip_no=null;
			$('#shelve').focus();
			}
		}else
		{
			
			responsiveVoice.speak("Shelve Scanned")
		
			$scope.Message='Shelve Number #'+$scope.shelve;
			$scope.slip_no=null;
			
			}
			$('#scan_awb').focus();
			
			
			
		}
		else
		{
			//onLoadWatingPoupupClose
			responsiveVoice.speak("AWB empty")
		
			$scope.warning='AWB empty!';
			$scope.slip_no=null;
			
			}
			$('#scan_awb').focus();
		}
  $scope.submitForm = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.GetAccountlist=[];
		  }
		   Data.post('WarehouseManagement/Showawbno',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				if(results.count==1){
					  
					document.getElementById("fname_error").innerHTML="Shelve Number";
					   $scope.IsVisible1 = $scope.IsVisible1 ? false : true;
					    $scope.IsVisible = $scope.IsVisible ? false : true;
						 $scope.IsVisible2 = $scope.IsVisible2 ? false : true;
				}
				else if(results.count >0) 
				 {
                        angular.forEach(results.result,function(value) 
						{
                         document.getElementById("fname_error").innerHTML="Empty AWBNo!";
						    $scope.IsVisible = $scope.IsVisible ? true : false;

                        }); 
                    } 
					else
					{    
						 document.getElementById("fname_error").innerHTML="Scan Shelve First!";
						   $scope.IsVisible = $scope.IsVisible ? true : false;
                    }
					
			});
		};
		
		
		 $scope.viewScanShipment = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {  
		  $scope.ScanShipmentArray=[];
		  }
		   Data.post('WarehouseManagement/showScanShipmentlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ScanShipmentArray.push(value);
						  document.getElementById("fname_error1").innerHTML="Report Generated!";

                        });
                    }
					else
					{$scope.nodata=true 
					document.getElementById("fname_error1").innerHTML="Shipmnent Not Available!";
                    }
			});
		}; 
		
		 $scope.exportToExcel=function(tableId){ // ex: '#my-table'
            var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
            $timeout(function(){location.href=exportHref;},100); // trigger download
        }
		
		 
			
	
   
});

app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
				 
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };  
});


app.factory('Excel',function($window){
        var uri='data:application/vnd.ms-excel;base64,',
            template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
            format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
        return {
            tableToExcel:function(tableId,worksheetName){
                var table=$(tableId),
                    ctx={worksheet:worksheetName,table:table.html()},
                    href=uri+base64(format(template,ctx));
                return href;
            }
        };
    })


app.controller('shipmentCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams, Excel, $timeout) {
	
	
	
    //initially set those objects to null to avoid undefined error
    $scope.listData = [];
	$scope.transferdata = [];
	$scope.transferdata1 = [];
	$scope.filterData = {};
	$scope.listarchieveData = [];
	$scope.listcustomerData=[];
	$scope.editshipmentArray={};
	$scope.userselected={};
	$scope.listassigningData=[];
	$scope.listDeleteedShipmentData=[];
	$scope.listDeleteedShipmentData=[];
	$scope.customerlist=[]; 
	  $scope.stafflist=[]; 
	$scope.statuslist=[]; 
	$scope.originlist=[]; 
	$scope.DetailListArray={};
	$scope.shipmentStatusArray=[];
	$scope.shipmentCourierArray=[];
	$scope.succmess="";
	$scope.errormess="";
	$scope.exportlimit = "";
		$scope.searchResult = [];
	 angular.element(document).ready(function () {
     $(".select2").select2();
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
	 $( "#datepicker3" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});        
	 $( "#datepicker4" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
	 $( "#datepicker5" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
	 $( "#datepicker6" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
	 $( "#datepicker7" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});   
	 $( "#datepicker8" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});  
	 
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
	 $scope.arrlist={};
	 
	 $scope.dropexportArr={};
	//alert("ssssss");
	
       $scope.showlistship = function (page_no,reset) { 
	   disableScreen(1);
		 $scope.loadershow=true; 
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.listData=[];
		  }
		 
		  if($stateParams.shelv_no!=undefined)
		  {
			console.log($stateParams.shelv_no);
			$scope.filterData.shelve_number=$stateParams.shelv_no;

		  }
		   Data.post('ShipmentManagement/allshiplist',$scope.filterData).then(function (results) {
			
			   console.log(results);
			   $scope.totalCount=results.count;
			   $scope.dropexportArr=results.dropexport;
			   $scope.values=results.result;
			 angular.forEach($scope.values, function(value, key) {
          $scope.listData.push(value); 
          });					
				//console.log(results);
			 disableScreen(0);
		 $scope.loadershow=false;	
			});
		};
		
		$scope.ManifestScanArr={};
		$scope.GetmanifestScanData = function (id,slip_no) { 
		$scope.ManifestScanArr.id=id;
		$scope.ManifestScanArr.slip_no=slip_no;
		   $("#updateshowPop").modal({ backdrop: 'static',
		keyboard: false})   
		};


		$scope.showlistship1 = function (search_type,main_status,shipmentStatus,statusBy) { 
		/*$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.listData=[];
		  }
		 
		  if($stateParams.shelv_no!=undefined)
		  {
			console.log($stateParams.shelv_no);
			$scope.filterData.shelve_number=$stateParams.shelv_no;

		  }*/
		  Data.post('ShipmentManagement/allshiplist1', {search_type:$stateParams.search_type,main_status:$stateParams.main_status,shipmentStatus:$stateParams.shipmentStatus,statusBy:$stateParams.statusBy}).then(function (results) {
			   console.log(results);
			   $scope.totalCount=results.count;
			   $scope.dropexportArr=results.dropexport;
			   $scope.values=results.result;
			 angular.forEach($scope.values, function(value, key) {
          $scope.listData.push(value); 
          });					
				//console.log(results);
				
			});
		};
		
		  $scope.showarchieveship = function (page_no,reset) {
			 console.log($scope.filterData);
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.listarchieveData=[];
		  }
		   Data.post('ShipmentManagement/allArchiveshiplist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
			   $scope.dropexportArr=results.dropexport;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.listarchieveData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
			
	
		};
   
		
	$scope.EditShipmentshow=function(custdata)
	{
		Data.post('ShipmentManagement/ShowEditShipment', {cusid:$stateParams.cusid}).then(function (results) {
			////console.log(results);
			$scope.editshipmentArray=results;
			$scope.editshipmentArray.cusid= $stateParams.cusid;

        });
	};
	

	$scope.fetchUsers = function(){  
                //alert(searchText);
	
		Data.post('ShipmentManagement/getData').then(function successCallback(response) {
			console.log(response);
			$scope.searchResult = response;
			$scope.newarray=[];
			angular.forEach($scope.searchResult, function(response){
				$scope.newarray.push(response.messenger_code+'/'+response.messenger_name+'/'+response.cor_id);      
			});
			
			var input = document.getElementById("show_messanger_dropdown");
			var awesomplete = new Awesomplete(input);

			/* ...more code... */

			awesomplete.list =$scope.newarray;
			console.log($scope.newarray);
		  });
	 
				  
	 }

	 $scope.shelveList = function(){  
		//alert(searchText);

Data.post('ShipmentManagement/getShelveData').then(function successCallback(response) {
	//console.log(response);
	$scope.searchResult = response;
	$scope.shelvearray=[];
	angular.forEach($scope.searchResult, function(response){
		$scope.shelvearray.push(response.shelv_no);      
	});
	
	var input = document.getElementById("show_Shelve_dropdown");
	var awesomplete = new Awesomplete(input);

	/* ...more code... */

	awesomplete.list =$scope.shelvearray;
	console.log($scope.shelvearray);
  });

		  
}





	   $scope.setValue = function(result){
		   //alert(result);
      $scope.searchText = result;
      $scope.searchResult = {};
     // $event.stopPropagation();
   }

   $scope.searchboxClicked = function($event){
	  // alert($event);
      $event.stopPropagation();
   }

   $scope.containerClicked = function(){
      $scope.searchResult = {};
   }
    
	
		$scope.GetShipmentdelete = function (id) {
		//alert (id); 
        Data.post('ShipmentManagement/get_delete_shipment', {id:id}).then(function (results) { 
			////console.log(results);
			alert("successfully deleted");
				$state.reload(); 
		});
    };
   
	$scope.GetShipmentRetrieve = function (id) {
		//alert (id); 
        Data.post('ShipmentManagement/get_retrieve_shipment', {id:id}).then(function (results) { 
			////console.log(results);
			alert("successfully Retrieved");
				$state.reload(); 
		});
    };
   
   		$scope.editShipmentstatus=function(custdata)
	{
		
		Data.post('ShipmentManagement/ShowEditShipmentStatus', {cusid:$stateParams.cusid}).then(function (results) {
			////console.log(results);
			$scope.userselected=results;  
			$scope.userselected.cusid= $stateParams.cusid;

        });
	};
	
	
	$scope.showCustomerDrop = function () {
			Data.post('ShipmentManagement/getCustomerDrop').then(function (results) { 
				// //console.log(results);
				 
				 $scope.customerlist=results;
			 });
		 };
	

	
	 
	$scope.showStaffDrop = function () {
			Data.post('ShipmentManagement/getStaffDrop').then(function (results) { 
				 ////console.log(results);
				 
				 $scope.stafflist=results;
			 });
		 }; 
		 
	$scope.showStatusDrop = function () {
			Data.post('ShipmentManagement/getStatusDrop').then(function (results) { 
				// //console.log(results);
				 
				 $scope.statuslist=results;
			 });
		 }; 
	
		$scope.showOriginDrop = function () {
			Data.post('ShipmentManagement/getOriginDrop').then(function (results) { 
				 ////console.log(results);
				 
				 $scope.originlist=results;
			 });
		 }; 
		
	   $scope.isAll = false;
        $scope.selectAllFriends = function() {
            if($scope.isAll === false) {
                angular.forEach($scope.listData, function(data){
                    data.checked = true;
                }); 
                $scope.isAll = true;
            } else {
                angular.forEach($scope.listData, function(data){
                    data.checked = false;
                });
                $scope.isAll = false;
            }
        };
		
		 $scope.DeleteCustomer = function(list) {  
        var itemList = [];  
        angular.forEach(list, function(value, key) {  
            if (list[key].checked) {     
                itemList.push(list[key].id);    
            }  
        });  
        //console.log(itemList.length); 
		Data.post('ShipmentManagement/DeleteShipment',{itemList:itemList}).then(function (results) {
			//$window.alert(itemList); 
			////console.log(itemList);  
			alert("Successfully Deleted");  
			$state.reload();
       
   	});  

	};
	
	$scope.diamentionArr={};
	$scope.SchedulingHistory={};
	
	$scope.GetShipmentDetailshow=function(custdata)
	{ 
		//alert("HIii");
		Data.post('ShipmentManagement/ShowShipDetails', {shid:$stateParams.shid}).then(function (results) {
			console.log(results);
			$scope.DetailListArray=results.shipInfo;
			$scope.DetailListArray.shid= $stateParams.shid;
			$scope.shipmentStatusArray=results.statusArray;
			$scope.shipmentStatusArray.slip_no= $stateParams.slip_no;
			$scope.shipmentCourierArray=results.messengerArray;
			$scope.SchedulingHistory=results.SchedulingHistory;
			
			$scope.diamentionArr= results.diamentionArr;
			

        });
	};
	

	$scope.GettrackDetailsshow=function(custdata)
	{       
		//alert("HIii");              
		Data.post('ShipmentManagement/getTrackDetails', {shid:$stateParams.shid}).then(function (results) {
			console.log(results);
			$scope.DetailListArray=results;        
			
			

        });
	};
	
	$scope.GetArchieveDetailshow=function(custdata)
	{ 
		//alert("HIii");
		Data.post('ShipmentManagement/ShowArchieveDetails', {shid:$stateParams.shid}).then(function (results) {
			console.log(results);
			$scope.DetailListArray=results.shipInfo;
			$scope.DetailListArray.shid= $stateParams.shid;
			$scope.shipmentStatusArray=results.statusArray;
			$scope.shipmentStatusArray.slip_no= $stateParams.slip_no;
			$scope.shipmentCourierArray=results.messengerArray;
			$scope.SchedulingHistory=results.SchedulingHistory;
			
			$scope.diamentionArr= results.diamentionArr;
			

        });
	};
	
	
	$scope.GetStatusShow=function(slip_no)
	{ 
		////console.log(slip_no);
		Data.post('ShipmentManagement/ShowShipmentStatus', {slip_no:$stateParams.slip_no}).then(function (results) {
			////console.log(results);
			$scope.shipmentStatusArray=results;
			$scope.shipmentStatusArray.slip_no= $stateParams.slip_no;

        });
	};
	
	$scope.GetCourierStaff=function(messanger_id) 
	{ 
		////console.log(messanger_id);
		Data.post('ShipmentManagement/ShowCourierStaff', {messanger_id:$stateParams.messanger_id}).then(function (results) {
			////console.log(results);
			$scope.shipmentCourierArray=results;
			$scope.shipmentCourierArray.messanger_id= $stateParams.messanger_id;

        });
	};
	
	$scope.subStactusArr={};
	$scope.originArr={};
	$scope.messangerArr={};
	 
	$scope.getdetails = function () {
if($scope.userselected.userid == "1" || $scope.userselected.userid == "10" || $scope.userselected.userid == "8")
{
	 Data.post('ShipmentManagement/Getallsubcatdata', {statusid:$scope.userselected.userid}).then(function (results) {
			////console.log(results);
			$scope.subStactusArr=results;
			

        });
$scope.result = true;
}
else
$scope.result = false;

if ($scope.userselected.userid == "3" || $scope.userselected.userid == "5"  || $scope.userselected.userid == "14" || $scope.userselected.userid == "11" || $scope.userselected.userid == "13")
{
	//alert('dddd');
	 Data.post('ShipmentManagement/messangerDataShow', {statusid:$scope.userselected.userid}).then(function (results) {
			//console.log(results);
			$scope.messangerArr=results;
			

        });
$scope.result3 = true;
}
else
$scope.result3 = false;

if ($scope.userselected.userid == "7"  || $scope.userselected.userid == "14" )
{
	 Data.post('ShipmentManagement/inter_originData', {statusid:$scope.userselected.userid}).then(function (results) {
			////console.log(results);
			$scope.originArr=results;
			

        });
$scope.result1 = true;
}
else
$scope.result1 = false;


if ($scope.userselected.userid == "11" || $scope.userselected.userid == "13")
$scope.result2 = true;
else
$scope.result2 = false;
}



	
		$scope.shipmentform = function (add_new_shipment) {
		  //console.log(add_new_shipment);
		
        Data.post('ShipmentManagement/AddShipment', {
            add_new_shipment: add_new_shipment
        }).then(function (results) {
			//console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);   
				
				$state.go('all_shipment');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	

	$scope.transferShip = function (ManifestScanArr) {
		//console.log(add_new_shipment);
	  
	  Data.post('ShipmentManagement/addtransferShipment1', {
		ManifestScanArr: ManifestScanArr
	  }).then(function (results) {
		  //console.log(results);  
		 
		  if (results== 'true') {
			  // Data.toast(results);   
			  
			  $scope.succmess="Shipment transferred Successfully"; 
			  $scope.errormess="";
		   }
		   else
		   {
			   $scope.errormess="Error! shipment not available or already Added in list";
			   $scope.succmess="";
		   }
			 
	  });
  };
	
	
	    $scope.errorshowwrongAbw={};
		$scope.emtyerr="";
		$scope.AssignShipmentform = function (assign_shipment) {
		  //console.log(assign_shipment);
		
        Data.post('ShipmentManagement/AddAssignShipment', {
            assign_shipment: assign_shipment 
        }).then(function (results) {
			console.log(results);  
			
		   
            if (results== 'true') {
				// Data.toast(results);   
				
				//$state.go('all_shipment');	 
				
            }
			else
			{
				$scope.errorshowwrongAbw=results.returnR;
			    $scope.emtyerr=results.returnR.errmess;
			
			}
        });
    };
	
	
	
	
	$scope.EditShipmentStatusform = function (edit_status) {
		  //console.log(edit_status);
		
        Data.post('ShipmentManagement/AddShipmentStatus', {
            edit_status: edit_status
        }).then(function (results) {
			//console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);   
				
				$state.go('all_shipment');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	
		$scope.EditShipmentform = function (edit_shipment) {
		  //console.log(edit_shipment);
		
        Data.post('ShipmentManagement/AddEditShipment', {
            edit_shipment: edit_shipment
        }).then(function (results) {
			//console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);   
				
				$state.go('all_shipment');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };


		$scope.AddShipmentFileform = function (edit_status) {
		  //console.log(edit_status);  
		 
        Data.post('ShipmentManagement/AddShipmentFile', {
            edit_status: edit_status
        }).then(function (results) {
			//console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);   
				
				$state.go('all_shipment');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	$scope.AssignStaffArr={};
	 $scope.GetCsaStaffLis = function () {
		   Data.post('ShipmentManagement/allGetCsaStaffLis').then(function (results) {
			
			    $scope.AssignStaffArr=results;
				
			});
		};
	 $scope.SearchAssignarr={};
	 $scope.showassigningship = function (SearchAssignarr) {
		//alert("ssssss");
		   Data.post('ShipmentManagement/allAssignShipmentlist', $scope.SearchAssignarr).then(function (results) {
			   $scope.listassigningData=results.result;
				console.log(results);
			
			});
		};
   
   $scope.exportToExcel = function (exportlimit) { // ex: '#my-table'
			console.log('yyyggg');
			console.log(exportlimit);
			
			console.log($scope.exportlimit);

           //var exportHref = Excel.tableToExcel(tableId, 'sheet name');
		   Data.post('ShipmentManagement/GetshipmentExportData',{cond:$scope.filterData,limit:$scope.exportlimit}).then(function (results) {
			var $a = $("<a>");
			$a.attr("href",results.file);
			$("body").append($a);
			$a.attr("download",results.file_name);
			$a[0].click();
			$a.remove();
          });
            
        }
	
	 $scope.exportToExcel1 = function () { // ex: '#my-table' 

			console.log($scope.exportlimit);

           //var exportHref = Excel.tableToExcel(tableId, 'sheet name');
		   Data.post('ShipmentManagement/GetArchshipmentExportData',{cond:$scope.filterData,limit:$scope.exportlimit}).then(function (results) {
			var $a = $("<a>");
			$a.attr("href",results.file);
			$("body").append($a);
			$a.attr("download",results.file_name);
			$a[0].click();
			$a.remove();
          });
            
        }
		
		 $scope.exportToExcelDown = function () { // ex: '#my-table' 

			//console.log($scope.exportlimit);

           //var exportHref = Excel.tableToExcel(tableId, 'sheet name');
		   Data.post('ShipmentManagement/GetDelshipmentExportData',{cond:$scope.filterData,limit:$scope.exportlimit}).then(function (results) { 
			var $a = $("<a>");
			$a.attr("href",results.file);
			$("body").append($a);
			$a.attr("download",results.file_name);
			$a[0].click();
			$a.remove();
          });
            
        }
 $scope.exportToExcelss = function (tableId) { // ex: '#my-table'

             var exportHref = Excel.tableToExcel(tableId, 'Today Shipmrnts'); 
            $timeout(function () { location.href = exportHref; }, 100); // trigger download
         }

		
		
	$scope.showdeletedship = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.listDeleteedShipmentData=[];
		  }
		   Data.post('ShipmentManagement/allDeletedshiplist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
			     $scope.dropexportArr=results.dropexport;
				//console.log(results); 
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.listDeleteedShipmentData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
   
   $scope.listreadyDetailsArr={};
   $scope.showreadyDeliverDeatils=function()
   {
		$scope.filterData.drs_unique_id=$stateParams.uid;
		
		 
		   Data.post('ShipmentManagement/allreadydeliverlist_details',$scope.filterData).then(function (results) {
			   $scope.listreadyDetailsArr=results.shipment_detail;
				console.log(results); 
				 
			});
			
			
		}
		
		$scope.listExcelDetailsArr={};
   $scope.showExcelDeliverDeatils=function() 
   {
		$scope.filterData.drs_unique_id=$stateParams.uid;
		
		 
		   Data.post('ShipmentManagement/allExceldeliverlist_details',$scope.filterData).then(function (results) {
			   $scope.listExcelDetailsArr=results.shipment_detail;
				console.log(results); 
				 
			});
			
			
		}
   	$scope.showreadyDeliver = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.listDeleteedShipmentData=[];
		  }
		   Data.post('ShipmentManagement/allreadydeliverlist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results); 
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.listDeleteedShipmentData.push(value);
 
                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   $scope.originlistss={};
   $scope.shelvearrays=[];
   	$scope.showOriginDropss = function () {
		
			Data.post('ShipmentManagement/RouteCityDrop').then(function (results) { 
				// console.log(results);
				
				 $scope.originlistss=results;
				$scope.shelvearrays=[];
				angular.forEach($scope.originlistss, function(results){
					$scope.shelvearrays.push(results.city);       
				});
				
				var input = document.getElementById("show_city_dropdown");  
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearrays; 
				console.log($scope.shelvearrays);


			 });
		 }; 
		 $scope.Suppdroplisr={};
		 $scope.shelvearrays1=[];
	$scope.Showsupplist = function () {
		
			Data.post('ShipmentManagement/SupplistDrop').then(function (results) { 
				// console.log(results);
				
				 $scope.Suppdroplisr=results;
				$scope.shelvearrays1=[];
				angular.forEach($scope.Suppdroplisr, function(results){ 
					$scope.shelvearrays1.push(results.messenger_name);       
				});
				
				var input = document.getElementById("show_city_dropdownss");  
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearrays1; 
				console.log($scope.shelvearrays1);


			 });
		 }; 
	
	
	 $scope.custdroplisr={};
		 $scope.shelvearrays2=[];
	$scope.ShowCustlist = function () {
		
			Data.post('ShipmentManagement/CustlistDrop').then(function (results) { 
				// console.log(results);
				
				 $scope.custdroplisr=results;
				$scope.shelvearrays2=[];
				angular.forEach($scope.custdroplisr, function(results){ 
					$scope.shelvearrays2.push(results.name);       
				});
				
				var input = document.getElementById("show_city_dropdownss1");  
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearrays2; 
				console.log($scope.shelvearrays2);


			 });
		 }; 
	
		$scope.Getpopoprncustdetais=function(cust_id,openid,type)
	{
	if(type=='two')   
	 Data.post('ShipmentManagement/ShowEditShipmentStatus', {cusid:cust_id}).then(function (results) {
			//console.log(results);
		   	$scope.transferdata=results;
        });
		else
		{
			
			Data.post('ShipmentManagement/ShowEditShipmentStatus', {cusid:cust_id}).then(function (results) {
			//console.log(results);
		   	$scope.transferdata=results;
			$scope.getallcitysdata();
        });
		}  
		  $(openid).modal('show') 
	}
	
	
		$scope.TransferShipment = function (transferdata) {
		  //console.log(transferdata);
		
        Data.post('ShipmentManagement/AddTransferShipment', {
            transferdata: transferdata
        }).then(function (results) {
			//console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);   
				
				$state.reload();	 
				 
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	
	  
		$scope.sendSmsShipment = function (sendsms) {
		  //console.log(sendsms);
        Data.post('ShipmentManagement/SendSMS',
            $scope.transferdata
        ).then(function (results) {
			//console.log(results);  
            if (results=='true') {
				// Data.toast(results);   
				alert("sms sent successfully");
				$('#exampleSendSMS').modal('hide');
				$state.reload(); 
				 
            }
			else
			{
				alert("all field are required");
			
			}
        });
    };
	
	
	
		$scope.getphonedetails = function () {
			if ($scope.transferdata.mobile_no == "1" )
			{
				$scope.result1 = true;
				$scope.result2 = false;
			}
			else
			{
				$scope.result2 = true;
				$scope.result1 = false;
			}
				
		   
	}
	//$scope.filterData.shipmentStatus='O';
	$scope.filterData.search_type="AWB";
	$scope.transferdata.search_type="Enter AWB No";  
	$scope.searchtype = function (search_type) {
		if(search_type=="AWB"){
			$scope.transferdata.search_type="Enter AWB No";
		}else if(search_type=="SN"){
			$scope.transferdata.search_type="Sender Name";
		}else if(search_type=="RE"){
			$scope.transferdata.search_type="Receiver Name";
		}else if(search_type=="SE"){
			$scope.transferdata.search_type="Sender Mobile";
		}else if(search_type=="RP"){
			$scope.transferdata.search_type="Receiver Mobile";
		}else if(search_type=="BN"){
			$scope.transferdata.search_type="Reference No.";
		}else if(search_type=="Email"){
			$scope.transferdata.search_type="Email";
		}
		
		
		 
	}

	 
	$scope.templateArray={};
	$scope.getallcitysdata=function(userselected)
	{
		////console.log(userselected); 
		Data.post('ShipmentManagement/Getalltemplatename', {userselected:$stateParams.userselected}).then(function (results) {
			//console.log(results);
			$scope.templateArray=results;

        });
	};
	$scope.transferdata.templates="";
	$scope.GettemplateMessage=function(template_id)
	{
		////console.log(userselected); 
		Data.post('ShipmentManagement/Getalltemplatename', {template_id:template_id}).then(function (results) {
			console.log(results);
			$scope.transferdata.templates=results.templates;

        });
	};
	
	
	
	$scope.messArray1={};
	$scope.messArray2={};
	$scope.messArray3={};
	$scope.messArray4={};
	$scope.messArray5={};
	$scope.messArray6={};
	$scope.messArray7={};
	$scope.messArray8={};
	$scope.messArray9={};
	$scope.messArray10={};
	$scope.messArray11={};
	$scope.messArray12={};
	$scope.mainstatusEmpty="";
	$scope.courier_error="";
	
	$scope.bulkUpdateform = function (edit_status) {
		  console.log($scope.userselected);
		
        Data.post('ShipmentManagement/AddBulkUpdate', $scope.userselected).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				$scope.userselected={};
				// Data.toast(results);   
				alert("status updated");
				//$state.go('bulk_update');	 
				
            }
			else
			{
				$scope.userselected={};
				$scope.messArray1=results.resultarr.wrong_awb;    
				$scope.messArray2=results.resultarr.deliverd_awb;
				$scope.messArray3=results.resultarr.refused_awb;
				$scope.messArray4=results.resultarr.in_memi_awb;
				$scope.messArray5=results.resultarr.status_issue;
				$scope.messArray6=results.resultarr.schedule_issue;
				$scope.messArray7=results.resultarr.not_ready_for_deliver;
				$scope.messArray8=results.resultarr.rtc_awb;
				$scope.messArray9=results.resultarr.success_update;
				$scope.messArray10=results.resultarr.menifest_awbs;
				$scope.messArray11=results.resultarr.inbound_issue;
				$scope.messArray12=results.resultarr.not_in_selve;
				$scope.mainstatusEmpty=results.resultarr.mainstatusEmpty;
				$scope.courier_error=results.resultarr.courier_error;
			
			
			}
        });
    };
	

	
		  $scope.loadcountry = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		 
		
			   Data.post('ShipmentManagement/GetallCountryList',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
			    $scope.arrlist=results;
				//console.log(results);
				 
			});
			
			
			
		};
		
		$scope.MainStatusArr={};
		 $scope.GetmainstatusDrop = function () {
			   Data.post('ShipmentManagement/ShowaminstatusDropData').then(function (results) {
			    $scope.MainStatusArr=results;
				//console.log(results);
				 
			});
			
			
			
		};
		
		
   
   
   
   $scope.arrlist1 = [{
"userid": 1,
"name": "Suresh"
}, {
"userid": 2,
"name": "Rohini"
}, {
"userid": 3,
"name": "Praveen"  
}];



  
});

 app.directive('loading',   ['$http' ,function ($http)  
 {  
     return {  
         restrict: 'A',  
         template: '<div class="loading-spiner"><img src="http://www.nasa.gov/multimedia/videogallery/ajax-loader.gif" /> </div>',  
         link: function (scope, elm, attrs)  
         {  
             scope.isLoading = function () {  
                 return $http.pendingRequests.length > 0;  
             };  
  
             scope.$watch(scope.isLoading, function (v)  
             {  
                 if(v){  
                     elm.show();  
                 }else{  
                     elm.hide();  
                 }  
             });  
         }  
     };  
 }])  


app.factory('Excel', function ($window) {
    var uri = 'data:application/vnd.ms-excel;base64,',
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) { return $window.btoa(unescape(encodeURIComponent(s))); },
        format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) };
    return {
        tableToExcel: function (testTable_new, worksheetName) {
            var table = $(testTable_new),
                ctx = { worksheet: worksheetName, table: table.html() },
                href = uri + base64(format(template, ctx));
            return href;
        }
    };
})


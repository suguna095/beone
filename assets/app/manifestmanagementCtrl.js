app.controller('manifestmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
   $scope.update_dateArray={};
   $scope.add_comArray={};
   $scope.edit_compidArray={};
    $scope.TransitData={};
	$scope.line_detailArray={}; 
	$scope.Detailsarray={};
	$scope.NotFoundarray={};
	$scope.manifestArray=[];
	$scope.manifestData=[];
	 $scope.filterData = {};
	 $scope.totalCount=0;
	 $scope.LineHolePost={};
	 $scope.updateArr={};
   //$scope.edit_compidArray.editid=$stateParams.editid;
  // alert($stateParams.editid);
	//alert("ssssss"); 
	 $scope.updateArr.return='N';
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
    
	 $scope.showmanifest = function (page_no,reset) {
		  disableScreen(1);
		 $scope.loadershow=true; 
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.manifestArray=[];
		  }
		   Data.post('ManifestManagement/showmanifest',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.manifestArray.push(value);

                        });
                    }
					 disableScreen(0);
		 $scope.loadershow=false; 
					
			});
		};
   
   $scope.CUstomerArr={};
   $scope.citydropshow=true;
    $scope.custIDshow=false;
       $scope.GetcheckManifestType=function(returval)
	   {
		    disableScreen(1);
		 $scope.loadershow=true; 
		 if(returval=='Y')
		 {
			  $scope.citydropshow=false;
			   $scope.custIDshow=true;
			 Data.post('ManifestManagement/GetCUstomerDropShow').then(function (results) { 
			  $scope.CUstomerArr=results;
			 });
		 }
		 else
		 {
			 $scope.CUstomerArr={};
			  $scope.custIDshow=false;
			  $scope.citydropshow=true;
		 }
		   disableScreen(0);
		 $scope.loadershow=false; 
		   
	   }
	   $scope.bulkmanifesterr={};
	   $scope.GetUpdateBulkManifestPage=function()
	   {
		    disableScreen(1);
		 $scope.loadershow=true; 
		    Data.post('ManifestManagement/GetbulkManifestUpdate',$scope.updateArr).then(function (results) { 
			console.log(results);
			$scope.bulkmanifesterr=results;
			  //$scope.CUstomerArr=results;
			   disableScreen(0);
		 $scope.loadershow=false; 
			 });
	   }
		$scope.originlist=[];
		$scope.showOriginDrop = function () {
			//alert("hi");
			Data.post('ManifestManagement/GetCityDrop').then(function (results) { 
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
		 
		 
		 $scope.originlist=[];
		 $scope.usertype="";
		$scope.showOriginDropUpdate = function () {
			 disableScreen(1);
		 $scope.loadershow=true; 
			Data.post('ManifestManagement/getOriginDrop').then(function (results) { 
				 console.log(results);
				 $scope.usertype=results.type;
				 $scope.originlist=results.citydrop;
				  disableScreen(0);
		 $scope.loadershow=false; 
		 $scope.updateArr.awb_no="";
				
			 });
		 };    
	     

		 	$scope.showDestinationDrop = function () {
			Data.post('ManifestManagement/GetCityDrop').then(function (results) { 
				 console.log(results);
				 
				 $scope.originlists=results;
				 
				 $scope.shelvearray=[];
				angular.forEach($scope.originlists, function(results){ 
					$scope.shelvearray.push(results.city);          
				});
				
				var input = document.getElementById("show_detination_dropdown");
				var awesomplete = new Awesomplete(input);   

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;
				console.log($scope.shelvearray);
			 });
		 }; 

 $scope.CityDropList={};
	   $scope.ShowCityDropdata=function()
	   {
		 Data.post('ManifestManagement/GetCityDrop').then(function (results) {
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
		 Data.post('ManifestManagement/GetCityDrop').then(function (results) {
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

	$scope.Getmanifestdelete = function (uniqueid) {
		
        Data.post('ManifestManagement/get_delete_manifest', {uniqueid:uniqueid}).then(function (results) { 
			console.log(results);
		   alert("Successfully deleted");
		 $window.location.reload();
          // $scope.edit_compidArray=results;
        });
    };
	
	
	$scope.CustomerDropArr={};
	$scope.CityDropArr={};
	
	 $scope.returnmanifest = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.manifestData=[];
		  }
		   Data.post('ManifestManagement/returnmanifest',$scope.filterData).then(function (results) {  
			   $scope.totalCount=results.count;
			   $scope.CustomerDropArr=results.CustomerDrop;
			   $scope.CityDropArr=results.CityDrop;
				console.log(results);   
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.manifestData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
		
		$scope.CheckslipNo=function(slip_no)
		{
			document.getElementById("checkslip"+slip_no).checked = true;
			$scope.filterData.scan_awb="";
			// data.checked = true;
			// $scope.isAll = true;
		}
		$scope.isAll = false;
        $scope.selectAllFriendsreturn = function() {
            if($scope.isAll === false) {
                angular.forEach($scope.manifestData, function(data){
                    data.checked = true;
                }); 
                $scope.isAll = true;
            } else {
                angular.forEach($scope.manifestData, function(data){
                    data.checked = false;
                });
                $scope.isAll = false;
            }
        };
	
	
	$scope.GetupdatemanifestChekData= function(dataArr)
	{
		
		 var itemList = [];  
        angular.forEach(dataArr, function(value, key) {  
            if (dataArr[key].checked) {     
                itemList.push(dataArr[key].id);    
            }  
        }); 
		 Data.post('ManifestManagement/GetupdatemanifestChekData',itemList).then(function (results) {
			if(results=='true')
			{
				alert("successfully Added");
				 $window.location.reload();
			}
			else
			alert("try again");
		});
		
		
		
	}
	$scope.retunArr1={};
	$scope.updateform = function (update_date) {
        Data.post('ManifestManagement/update_date', {
            update_date: update_date
        }).then(function (results) {
			
			console.log(results);
			 alert("Successfully Updated");
		  $scope.retunArr1=results.retunArr;
           
        });
    };
	
	$scope.add_comform = function (add_com) {
        Data.post('ManifestManagement/add_com', {
            add_com: add_com
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				 alert("Successfully Added");
				// Data.toast(results);
				$scope.add_comArray.comp_name="";
				$scope.get_comp_list();
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	
	
	
	
	
	$scope.Getdelete = function (id) {
	//	alert(id);
        Data.post('ManifestManagement/get_delete_update', {id:id}).then(function (results) { 
			console.log(results);
			 alert("Successfully deleted");
		   $scope.get_comp_list();
          // $scope.edit_compidArray=results;
        });
    };
	
	$scope.getEditData = function () {
        Data.post('ManifestManagement/get_edit_com_1', {editid:$stateParams.editid}).then(function (results) {
			console.log(results);
		   
           $scope.edit_compidArray=results;
        });
    };
	
	 $scope.get_comp_list = function () {
       Data.post('ManifestManagement/get_comp').then(function (results) { 
		   
			console.log(results);
			
		    $scope.get_comp=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	
	 $scope.edit_comform = function (comp_name) {
		//console.log(news);
        Data.post('ManifestManagement/edit_comform', {
            comp_name: $scope.edit_compidArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				 alert("Successfully Updated");
				$state.go('line_haul');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
  $scope.TimeUpdateArray={};
   $scope.GetdayUpdateForPage=function(counter,type)
   {
	   if(type=='day1')
	   {
	    document.getElementById('dayfield'+counter).style.display="block";
		 document.getElementById('dayfield2'+counter).style.display="none";
		 document.getElementById('dayfield3'+counter).style.display="block";
	   }
	   else
	   {
		    document.getElementById('timefield1'+counter).style.display="block";
		 document.getElementById('timefield2'+counter).style.display="none";
		 }
	   
   }
   
   $scope.GetupdateDaytimeData=function(id,counter,val,field)
   {
	    var checkday=1;
	   if(field=='day')
	   {
		  if(val>0)
		  var checkday=1;
		  else 
		   var checkday=0;
	   }
	   if(checkday==1)
	   {
	   $scope.TimeUpdateArray.id=id;
	   $scope.TimeUpdateArray.counter=counter;
	   $scope.TimeUpdateArray.val=val;
	   $scope.TimeUpdateArray.field=field;
	 Data.post('ManifestManagement/getTransitTime_update',$scope.TimeUpdateArray).then(function (results) {
		 console.log(results);
		   if(field=='day')
		   {
		      document.getElementById('dayfield'+counter).style.display="none";
		      document.getElementById('dayfield2'+counter).style.display="block";
		      document.getElementById('dayfield3'+counter).style.display="none";
		   }
		   else
		   {
			    document.getElementById('timefield1'+counter).style.display="none";
		        document.getElementById('timefield2'+counter).style.display="block";
		   }
	 })
	   }else
	   {
		   alert("please enter valid day");
	   }
	   
   }


	$scope.getTransitData = function () {
		   var ctrl = this;
  ctrl.time = '02:40PM';
		//alert($stateParams.getid);
        Data.post('ManifestManagement/getTransitTime', {getid:$stateParams.getid}).then(function (results) {
			console.log(results);
		   
           $scope.TransitData=results;
		 
        });
    };
	
	//==========Line Haul Popup Data=========/// 
	

	$scope.lineHaleDrop={};
	$scope.NewArrayData={};
	$scope.GetlineHaul = function (uniqueid) {
		//alert("sssss");
		$scope.NewArrayData.uniqueid=uniqueid;
		//alert($scope.line_detailArray.uniqueid);
        Data.post('ManifestManagement/get_uniqueid', {uniqueid:uniqueid}).then(function (results) {
			console.log(results);
		  // $scope.line_detailArray.uniqueid=uniqueid;
		   $scope.lineHaleDrop=results.lineHaleDrop;
           $scope.line_detailArray=results.detailsArr;
		//alert(uniqueid);
		     $("#linepopsho").modal({ backdrop: 'static',
    keyboard: false})  
        });
    }; 
		$scope.GetUpdateshowlineData=function()
	{
		//alert($scope.NewArrayData.uniqueid);
		$scope.line_detailArray.uniqueid=$scope.NewArrayData.uniqueid;
		  Data.post('ManifestManagement/GetUpdateshowlineDataProcess', $scope.line_detailArray).then(function (results) { 
			  alert("Successfully updated");
			  $('#linepopsho').modal('hide');
			  console.log(results);
		  });
	}
	$scope.getViewData = function (Sortcodebymani) {   
	$scope.manid=$stateParams.manid;
	if(Sortcodebymani)
	{
	$scope.Detailsarray=[];
	}
	//alert(Sortcodebymani);
        Data.post('ManifestManagement/view_manifest', {manid:$stateParams.manid,Sortcodebymani:Sortcodebymani}).then(function (results) {
			console.log(results);
		 
           $scope.Detailsarray=results;
        });
    };
	
	$scope.notFoundData = function () { 
	$scope.nfoundid=$stateParams.nfoundid;
        Data.post('ManifestManagement/view_manifest', {nfoundid:$stateParams.nfoundid}).then(function (results) {
			console.log(results);
		   
           $scope.NotFoundarray=results;
        });
    };
	$scope.ManifestScanArr={};
	$scope.GetmanifestScanData = function (id,uniqueid,return_menifest) { 
	$scope.ManifestScanArr.id=id;
	$scope.ManifestScanArr.uniqueid=uniqueid;
	$scope.ManifestScanArr.return_menifest=return_menifest;
       $("#updateshowPop").modal({ backdrop: 'static',
    keyboard: false})   
    };
	$scope.slip_array=[];
	$scanManifestReturnArr={};
	$scope.succmess="";
	$scope.errormess="";    
	$scope.GetscanManifest = function()
	{  
	  disableScreen(1);
		 $scope.loadershow=true; 
	//alert("hi");                                            
    $scope.slip_no=$scope.ManifestScanArr.awb.trim();
	$scope.slip_array.push($scope.slip_no);
	$scope.awb_no=$scope.slip_array;
	$scope.ManifestScanArr.slip_array=$scope.awb_no;
	$scope.ManifestScanArr.staus_id=1;
	$scope.ManifestScanArr.single_slip_no=$scope.slip_no;
	
	//console.log($scope.ManifestScanArr);
	
	 Data.post('ManifestManagement/ShipmentListForManifest', $scope.ManifestScanArr).then(function (results) {
		 console.log(results);
		 if(results.status==true)    
		 {
			 
			$scope.scanManifestReturnArr=results.status;
			$scope.scanManifestReturnArr=results.retrun_value;
			$scope.succmess=$scope.slip_no+"Shipment Added Successfully In list"; 
			$scope.errormess="";
		 }
		 else
		 {
			 $scope.errormess="Error! shipment not available or already Added in list";
			 $scope.succmess="";
		 }
		     disableScreen(0);
		 $scope.loadershow=false; 
           
        });
	
	};    
	
	$scope.GetUpdatemanifestActive=function(uniqueid,type)
	{
		Data.post('ManifestManagement/ManifestActive',{uniqueid:uniqueid,type:type}).then(function (results) {
		// console.log(results);
		 alert("Successfully Updated");
		 $window.location.reload();
		});   
	}
	
	
	
});
app.directive('clockPicker', function() {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {
      element.clockpicker({ format:"HH:MM:SS"});
    }
  }
});
app.directive('stringToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value, 10);
      });
    }
  };
});
	
/*app.directive('ngEnter', function() {
	return function(scope, element, attrs) {
		element.bind("keydown keypress", function(event) {
			if(event.which === 13) {     
				scope.$apply(function(){
					scope.$eval(attrs.ngEnter, {'event': event});
				});

				event.preventDefault();   
			}
		});
	};
});*/           
     

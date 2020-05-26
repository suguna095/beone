app.controller('schedulemanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
 
 $scope.categorylist={};
  $scope.retunArr1=[]; 
  $scope.retunArr2=[];
 $scope.IsVisible = false;
 $scope.IsVisible1 = true;
  $scope.filterData={};
 $scope.filterData.timeslot="8:00 PM To 12:00 AM";
  angular.element(document).ready(function () {
   
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    });	  
		 $scope.changeme = function() { 
         //alert('here');
          }
		 $scope.changeme1 = function() { 
         //alert('here');
          }
   
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
   
	 $scope.showReasonDrop = function () {
       Data.post('ScheduleManagement/ReasonDrop').then(function (results) { 
			console.log(results);
			
		    $scope.categorylist=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
 
    
    $scope.UpdatenotSched = function (notschedArray) {   
		//alert("HI");
		  console.log(notschedArray);
       Data.post('ScheduleManagement/NotSchedule', {
            notschedArray: notschedArray
        }).then(function (results) {
			console.log(results);  
		   
			$scope.retunArr2=results.retunArr;
			console.log($scope.retunArr2); 
        });
    };
       
	
	 $scope.UpdateSched = function (scheduledArray) {  
		  console.log(scheduledArray);
        Data.post('ScheduleManagement/ScheduleUpdate', {
            scheduledArray:scheduledArray 
        }).then(function (results) {
			console.log(results);  
		   
			$scope.retunArr2=results.retunArr;
			console.log($scope.retunArr2); 
        });
    };
	
	$scope.GetBlindSchedule = function (page_no,reset) {
		
		
		
        $scope.IsVisible = $scope.IsVisible ? false : true;
		 $scope.IsVisible1 = $scope.IsVisible ? true : false;
		$scope.filterData.page_no=page_no;
		
		  if(reset==1)
		  {
		  $scope.Blindlist=[];
		  }
		   Data.post('ScheduleManagement/BlindSchedule',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
                          $scope.Blindlist.push(value);  

                        });
                    }
					else
					{
						$scope.nodata=true 
                    }
			});
		};
		
	
	
	$scope.bulkReshedule = function (bulkArray) {
		//console.log(bulkArray);
        Data.post('ScheduleManagement/BulkResheduleUpdate', { 
            bulkArray: bulkArray
        }).then(function (results) {
			
		  $scope.retunArr2=results.retunArr;
           console.log($scope.retunArr2);  
        }); 
    };
	
	$scope.blindshedule = function (filterData) {
		console.log(filterData);
        Data.post('ScheduleManagement/BlindResheduleUpdate', { 
            filterData: filterData
        }).then(function (results) {
			
		 alert("area Updated"); 
        }); 
    };
	
	
	
	
	$scope.GetScheduleRemove = function (removeArray) {
        Data.post('ScheduleManagement/BulkRemove', {
            removeArray: removeArray
        }).then(function (results) {
			
		  $scope.retunArr1=results.retunArr;
           console.log($scope.retunArr1);
        });
	};
	
	$scope.searchResult ={};
	$scope.rootList = function(){        
//alert("hi");

Data.post('ScheduleManagement/getRootData').then(function successCallback(response) {
	console.log(response);   
	$scope.searchResult = response;
	$scope.shelvearray=[];
	angular.forEach($scope.searchResult, function(response){
		$scope.shelvearray.push(response.route);       
	});
	
	var input = document.getElementById("show_root_dropdown");  
	var awesomplete = new Awesomplete(input);

	/* ...more code... */

	awesomplete.list =$scope.shelvearray;
	console.log($scope.shelvearray); 
  });

		  
}


	
	 
	/* $scope.GetScheduleRemove = function () {
		  console.log($scope.removeArray); 
		
		  Data.post('ScheduleManagement/BulkRemove', $scope.removeArray).then(function (results) {
		 if (results== 'true') {
				$scope.removeArray={};
				// Data.toast(results);   
				alert("status updated");
				//$state.go('bulk_update');	 
				
            }
			else
			{
				$scope.removeArray={};
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
    }; */
	function Getloginalerttrue(title,mess,type,icon)
		 {  
				$.alert({
					title: title,
					icon: icon,
                    type: type,
					content: mess,
					buttons: {
						close: function () {
							 $state.reload();
						},
					}
				});
		 }

		 $scope.Warningshow={};
	 $scope.uploadExcel = function(value){
		  disableScreen(1);
		 $scope.loadershow=true; 
		  var filedata=new FormData();
		  angular.forEach($scope.uploadfiles,function(file){
		  filedata.append('file',file);
		 });
//console.log(filedata);
	   $http({
	  method: 'post',
	  url: 'ScheduleManagement/UploadEcelArea',
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



});

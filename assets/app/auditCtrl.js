app.controller('auditCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.viewreasonData=[];
	$scope.viewauditData=[];
	$scope.viewCSauditData=[];
	 $scope.viewOPauditData=[];
    $scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.editreasonArray={};
	$scope.statuslist=[];
	$scope.statuslist1=[];
	$scope.modaldata={}; 
	$scope.originlist=[];
	$scope.total_complete=[];
	$scope.total_pending=[];
	//alert("ssssss");
   
    $scope.isAll = false;
        $scope.selectAllFriends = function() {
            if($scope.isAll === false) {
                angular.forEach($scope.viewauditData, function(data){
                    data.checked = true;
                }); 
                $scope.isAll = true;
            } else {
                angular.forEach($scope.viewauditData, function(data){
                    data.checked = false;
                });
                $scope.isAll = false;
            }
        };
		
   
    angular.element(document).ready(function () {
   
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    });
	
	$scope.showOriginDrop = function () {
			Data.post('ShipmentManagement/getOriginDrop').then(function (results) { 
				 ////console.log(results);
				 
				 $scope.originlist=results;
			 });
		 };
		 
    $scope.getStatusDrop = function () {
			Data.post('Audit/getStatusListDrop').then(function (results) { 
				 ////console.log(results);
				 
				 $scope.statuslist=results;
			 });
		 };
	 $scope.GetEmailSendPopup=function(id,popid)
  {
		 Data.post('Audit/getAuditData', {id:id}).then(function (results) {
		//	console.log(results);
			$scope.modaldata=results;
			//$scope.MailDataArray.id= custdata.id;

        });
	  $(popid).modal('show');
	
  };
  
  
  	 $scope.GetEmailSendPopup1=function(id,popid1)
  {
		 Data.post('Audit/getAuditData', {id:id}).then(function (results) {
		//	console.log(results);
			$scope.modaldata=results;
			//$scope.MailDataArray.id= custdata.id;

        });
	  $(popid1).modal('show');
	
  };


  $scope.GetCSAuditPopup=function(id,popid)
  {
		 Data.post('Audit/getAuditData', {id:id}).then(function (results) {
		//	console.log(results);
			$scope.modaldata=results;
			//$scope.MailDataArray.id= custdata.id;

        });
	  $(popid).modal('show');   
	
  };
  
  
  	 $scope.GetCSAuditPopup1=function(id,popid1)
  {
		 Data.post('Audit/getAuditData', {id:id}).then(function (results) {
		//	console.log(results);
			$scope.modaldata=results;
			//$scope.MailDataArray.id= custdata.id;

        });
	  $(popid1).modal('show');
	
  };


	 $scope.viewReason = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewreasonData=[];
		  }
		   Data.post('Audit/view_reason',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.viewreasonData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
	
	$scope.ExcelReasonList={};
	$scope.ShowReasExceView=function()
	{
		
		Data.post('Audit/view_reason_Excel').then(function (results) {
		//	console.log(results);
		
			$scope.ExcelReasonList=results;
			
        });
	};
	
    $scope.AddReasonform = function (add_reason) {
		  //console.log(add_route);
        Data.post('Audit/add_reason', {
            add_reason: add_reason
        }).then(function (results) {
			//console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Added Successfully");
				$state.go('view_reason');	 
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
   
    
     $scope.GetReasondelete = function (id) {
		//alert (id); 
        Data.post('Audit/get_delete_reason', {id:id}).then(function (results) { 
			//console.log(results);
		   alert("Deleted Successfully");
		  $state.reload();
          // $scope.edit_compidArray=results;
        });
    };
     
	 
	 $scope.EditReasonshow=function(custdata)
	{
		
		Data.post('Audit/geteditreasonData', {reid:$stateParams.reid}).then(function (results) {
		//	console.log(results);
		
			$scope.editreasonArray=results;
			$scope.editreasonArray.reid= $stateParams.reid;

        });
	};
	
	$scope.AddEditReasonform = function (edit_reason) {
	    //console.log(edit_staff);  
        Data.post('Audit/edit_reasonform', {
            edit_reason: $scope.editreasonArray
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				 alert("Updated Successfully");
				$state.go('view_reason');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	$scope.viewaudit = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewauditData=[];
		  }
		   Data.post('Audit/view_audit',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
					console.log(results);
					$scope.total_pending=results.total_pending;
					$scope.total_complete=results.total_complete;
					 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{  
                          $scope.viewauditData.push(value);

                        });
                    }
					else  
					{$scope.nodata=true
                    }
			
			});
		};
	
	
	$scope.viewCSaudit = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewCSauditData=[];
		  }
		   Data.post('Audit/view_CSaudit',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				$scope.total_pending=results.total_pending;
				$scope.total_complete=results.total_complete;
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{  
                          $scope.viewCSauditData.push(value);

                        });
                    }
					else  
					{$scope.nodata=true
                    }
					
				
				
			});
		};
		
		$scope.viewOPaudit = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewOPauditData=[];
		  }
		   Data.post('Audit/view_Operationaudit',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				$scope.total_pending=results.total_pending;
				$scope.total_complete=results.total_complete;
				if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{  
                          $scope.viewOPauditData.push(value);

                        });
                    }
					else  
					{$scope.nodata=true
                    }
					
				
			});
		};
		
		$scope.get_all_reason = function (astatus, id) {
		//alert (astatus);   
        Data.post('Audit/getStatusDrop', {astatus:astatus,id:id}).then(function (results) { 
		//console.log(results);
			$scope.statuslist=results;
        }); 
		};
		
		
		$scope.get_reason = function (astatus, id) {
		//alert (astatus);   
        Data.post('Audit/getReasonsDrop', {astatus:astatus,id:id}).then(function (results) { 
		console.log(results);
			$scope.statuslist1=results;
        }); 
		};
		
		
		$scope.updateStatusform = function (modaldata) {
	   // console.log(modaldata);  
       Data.post('Audit/UpdateStatus', {
		  
            modaldata: $scope.modaldata  
        }).then(function (results) {
			 //alert("ssss");
			console.log(results);
		   
		   
			alert("Updated Succeessfully"); 
			$('#exampleModalForms').modal('hide'); 
			$window.location.reload();
				
            
				
			
        }); 
    };
});
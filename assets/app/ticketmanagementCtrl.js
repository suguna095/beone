app.controller('ticketmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    $scope.viewticketData=[];
    $scope.filterData={};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
   $scope.ReplyDataArray={};

	
    $scope.viewticket = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewticketData=[];
		  }
		   Data.post('Tickets/show_ticket',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.viewticketData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};

	$scope.GetTicketdelete = function(id)
	{
		
        Data.post('Tickets/get_delete_ticket', {id:id}).then(function (results) { 
		console.log(results);
		alert("Deleted Successfully");
		 $state.reload();
		    
        });
    };

  

  $scope.GetEmailSendPopup=function(id,popid)
  {
	  Data.post('Tickets/ShowSendMailData', {id:id}).then(function (results) {
		//	console.log(results);
			$scope.MailDataArray=results;
			//$scope.MailDataArray.id= custdata.id;

        });
	  $(popid).modal('show');
  };
   
    $scope.GetEmailTicketsPopup=function(id,popids)
  {
	  Data.post('Tickets/ShowTicketdMailData', {id:id}).then(function (results) {
		//	console.log(results);
			$scope.TicketsDataArray=results;
			//$scope.MailDataArray.id= custdata.id;

        });
	  $(popids).modal('show');
  };

	$scope.ReplyMsgshow=function(custdata)
	{
		
		Data.post('Tickets/ShowReplyMsg', {id:$stateParams.id}).then(function (results) {
		//	console.log(results);
			$scope.ReplyDataArray=results;
			$scope.ReplyDataArray.id= $stateParams.id;
			$scope.TicketDetailsDataShow();

        });
	};
	$scope.ticketHistory={};
	$scope.TicketDetailsDataShow=function()
	{
		
		Data.post('Tickets/TicketDetailsDataShowPage', {ticketno:$scope.ReplyDataArray.ticket_no}).then(function (results) {
			console.log(results);
			$scope.ticketHistory=results;
			//$scope.ReplyDataArray=results;
			//$scope.ReplyDataArray.id= $stateParams.id;

        });
	};
	$scope.ShowTicketStatus = function (id,ticket_status) {
		//alert(id);
        Data.post('Tickets/TicketstatusUpdate', {id:id,ticket_status:ticket_status}).then(function (results) { 
			console.log(id);
			//alert(sssss);  
		    $state.reload();  
        });
    };
    
	//$scope.sendmess="";
	$scope.UpdateTicketReply = function (ReplyDataArray) {
		
	   
		//ReplyDataArray.replymess=$scope.sendmess;
		 console.log(ReplyDataArray);  
        Data.post('Tickets/UpdateReply', {
            ReplyDataArray:$scope.ReplyDataArray    
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				$scope.TicketDetailsDataShow();
				$scope.ReplyDataArray.sendmess="";
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
});
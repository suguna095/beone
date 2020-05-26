app.controller('ofdCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams,Excel,$timeout,$interval) {
    //initially set those objects to null to avoid undefined error
    $scope.newArray = {};
	 $scope.editArray = {};
	$scope.ListArray = {};
	$scope.customerlist=[]; 
	$scope.originlist=[]; 
	 $scope.listData=[];
	 $scope.filterData = {};
	 $scope.supplierlist=[];
	 $scope.DRSlistData=[];
	 $scope.deliveredlistData=[];
	 $scope.notdeliveredlistData=[];
	 $scope.runninglistData=[];
	 $scope.totalofdlist=[];	  
$scope.start_date=[];	  
$scope.end_date=[];	  
	
	$scope.ckdata = {
      textInput: 'pretext',
      options: {
        language: 'en',
        allowedContent: true,
        entities: false
      }
	}
	
	
 angular.element(document).ready(function () {
   
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});//.datepicker("setDate", new Date())
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});//.datepicker("setDate", new Date())
	
	
	 
    });	  
	
      $scope.getOfdData = function (page_no,reset) { 
	  //alert("hi");
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.listData=[];
		 /* $scope.DRSlistData=[];
		  $scope.deliveredlistData=[];
		  $scope.notdeliveredlistData=[];
		  $scope.runninglistData=[];*/
		  }
		   Data.post('OfdReport/allofdreportlist',$scope.filterData).then(function (results) {
			   
				console.log(results);
				if(results.totalinfo.length > 0)
				{
					$scope.listData=results.totalinfo;
					$scope.totalcompletedrs=results.totalcompletedrs;
					$scope.totaldelivered=results.totaldelivered;
					$scope.totalrunning=results.totalrunning;
					$scope.totalnotdeliverd=results.totalnotdeliverd;
					$scope.start_date=results.start_date;
					$scope.end_date=results.end_date;
				}else{
					$scope.listData=results.totalinfo;
					$scope.totalcompletedrs=0;
					$scope.totaldelivered=0;
					$scope.totalrunning=0;
					$scope.totalnotdeliverd=0; 
					$scope.start_date=results.start_date;
					$scope.end_date=results.end_date; 
				}
				
		})
	     
	  };
	//console.log($scope.editArray);
	//alert("ssssss");
    $scope.Addform = function (ofdreport) {
		//console.log(ofdreport);
        Data.post('OfdReport', {
            ofdreport: ofdreport
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('ofdreport');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	
		$scope.gettotalofd=function(custdata)
	{   
		//alert("HIii");
		Data.post('OfdReport/ShowtotalofdDetails', {messanger_id:$stateParams.messanger_id,drs_date:$stateParams.drs_date,drs_date2:$stateParams.drs_date2,ofdstatus:$stateParams.ofdstatus}).then(function (results) {
			console.log(results);
			$scope.totalofdlist=results.result;

		
        });
	};
	$scope.gettodayofd=function(custdata)
	{   
		//alert("HIii");
		Data.post('OfdReport/ShowtodayofdDetails', {messanger_id:$stateParams.messanger_id,drs_date:$stateParams.drs_date,ofdstatus:$stateParams.ofdstatus}).then(function (results) {
			console.log(results);
			$scope.totalofdlist=results.result;

		
        });
	};

	
	
		$scope.gettotalofddetails=function(custdata)
	{   
		//alert("HIii");
		Data.post('OfdReport/Showtotalofdlist', {start_date:$stateParams.start_date,end_date:$stateParams.end_date,ofdstatus:$stateParams.ofdstatus}).then(function (results) {
			console.log(results);
			$scope.totalofdlist=results.result;

		
        });
	};
	
	$scope.showOriginDrop = function () {
			Data.post('ShipmentManagement/getOriginDrop').then(function (results) { 
				 ////console.log(results);
				 
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
   
   
    $scope.chartcheckdetail=function(ofd,deli,ndeli,popid)
  {
	  /*Data.post('ShipmentManagement/ShowSendMailData', {id:id}).then(function (results) {
		//	console.log(results);
			$scope.MailDataArray=results;
			//$scope.MailDataArray.id= custdata.id;

        });*/
	  $(popid).modal('show');
	  chartcheckdetail_graph(ofd,deli,ndeli);
  };
  function chartcheckdetail_graph(ofd,deli,ndeli)
			{
				console.log(ofd+","+deli+","+ndeli);
				var total=parseInt(deli)+parseInt(ndeli)+parseInt(ofd);
				//var poidpersent=parseInt(poid)*100/total;
				var ofdpersent=parseInt(ofd)*100/total;
				var delipersent=parseInt(deli)*100/total;
				var ndelipersent=parseInt(ndeli)*100/total;
			new Chart(document.getElementById("doughnut-chart"), {
		type: 'doughnut',
		data: {
		  labels: ["Running %" ,"Delivered %", "Not Delivered %"],
		  datasets: [
			{
			  label: "Shipment Details",
			  backgroundColor: ["Blue","green","red"],
			  data: [ofdpersent.toFixed(2),delipersent.toFixed(2),ndelipersent.toFixed(2)]
			}
		  ]
		},
		 options: {
			 legend: {
				display: true
			 },
			 tooltips: {
				enabled: true
			 }
		
		}
	});
	}
  
   	$scope.showCustomerDrop = function () {
			Data.post('ShipmentManagement/getCustomerDrop').then(function (results) { 
				// //console.log(results);
				 
				 $scope.customerlist=results;
			 });
		 };
		
			$scope.showSupplierDrop = function () {
			Data.post('OfdReport/getSupplierDrop').then(function (results) { 
				// //console.log(results);
				 
				 $scope.supplierlist=results;
			 });
		 };
		 
		 
		  $scope.exportToExcel = function (testTable_new) { // ex: '#my-table'

            var exportHref = Excel.tableToExcel(testTable, 'sheet name');
            $timeout(function () { location.href = exportHref; }, 100); // trigger download
        } 
		 
});

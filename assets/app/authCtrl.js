app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window) {
    //initially set those objects to null to avoid undefined error
    $scope.logArray = {};
	//$scope.logArray.username ="";
	//$scope.logArray.password ="";
	$scope.errormess="";
    $scope.signup = {}; 
	//alert("ssssss");
    $scope.dologin = function (customer) {
		
        Data.post('Login', {
            customer: customer
        }).then(function (results) {
			///console.log(results);
		    //$scope.results.push(results); 
            if (results.status == 'success') {
				$scope.errormess="";
				 $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
				 $rootScope.logincheck=$window.sessionStorage.getItem('adminID');
				  $rootScope.authenticated=true;
				 $window.sessionStorage.setItem("adminUNAME",results.udata.localSession.A_USERNAME);
				  $window.sessionStorage.setItem("adminEMAIL",results.udata.localSession.A_EMAIL);
				  
			// var loggedIn = $cookies.get('loggedIn');
							// Setting a cookie
							//$cookies.put('loggedIn', true);
				//$scope.user = JSON.parse(sessionStorage.results);
				//$state.go('dashboard');
               ///$location.path('dashboard');
			   
			  //$window.location.reload('all_shipment');
			  
			    $window.location="dashboard";
				
			   //console.log($window.sessionStorage.getItem('adminID'));
			    //console.log($window.sessionStorage.getItem('adminUNAME'));
            }
			else
			{
				//alert(results.error);
			$scope.errormess=results.error;
			}
			//$scope.results.push(results); 
        });
    };
   
	$scope.totalcompletedrs=[];
	$scope.totaldelivered=[];
	$scope.totalrunning=[];
	$scope.totalnotdeliverd=[];
   
	    $scope.getOfdData = function () { 
	  //alert("hi");
		//$scope.filterData.page_no=page_no;
		  
		   Data.post('OfdReport/allofdreportlist1').then(function (results) {
			   
			//	console.log(results);
				if(results.totalinfo.length > 0)
				{
					$scope.listData=results.totalinfo;
					$scope.totalcompletedrs=results.totalcompletedrs;
					$scope.totaldelivered=results.totaldelivered;
					$scope.totalrunning=results.totalrunning;
					$scope.totalnotdeliverd=results.totalnotdeliverd;
				}else{
					$scope.listData=results.totalinfo;   
					$scope.totalcompletedrs=0;
					$scope.totaldelivered=0;
					$scope.totalrunning=0;
					$scope.totalnotdeliverd=0;  
				}
				
		})
	     
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
					//console.log(ofd+","+deli+","+ndeli);
					var total=parseInt(deli)+parseInt(ndeli)+parseInt(ofd);
					//alert(ofd);
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
    $scope.logout = function () {
		alert("ssssss");
      /*  Data.get('logout').then(function (results) { 
           // Data.toast(results);
           // $location.path('login');
		   $window.location="login";
        });*/
	}
	

	$scope.exportToExcel = function (testTable_new) { // ex: '#my-table'

            var exportHref = Excel.tableToExcel(testTable, 'sheet name');   
            $timeout(function () { location.href = exportHref; }, 100); // trigger download
        } 
	$scope.showDashboardData = function () { 
		Data.post('ShipmentManagement/getDashboardData').then(function (results) {
			//alert("Hi"); 
			console.log(results);
			 if(results.total_shipment>0)
			 {
				$scope.total_shipment=results.total_shipment;  
			 }else{
				$scope.total_shipment=0; 
			 }
			 if(results.total_coustomer>0)
			 {
				$scope.total_coustomer=results.total_coustomer;
			 }else{
				$scope.total_coustomer=0; 
			 }if(results.total_payment>0)
			 {
				$scope.total_payment=results.total_payment;
			 }else{
				$scope.total_payment=0; 
			 }if(results.total_customer>0)
			 {
				$scope.total_customer=results.total_customer;
			 }else{
				$scope.total_customer=0; 
			 }
			 if(results.not_delivered>0)
			 {
				$scope.not_delivered=results.not_delivered;
			 }else{
				$scope.not_delivered=0; 
			 }
		
			 if(results.pick_upcollected>0)
			 {
				$scope.pick_upcollected=results.pick_upcollected;
			 }else{
				$scope.pick_upcollected=0; 
			 }
		
			 if(results.outfordelivery>0)
			 {
				$scope.outfordelivery=results.outfordelivery;
			 }else{
				$scope.outfordelivery=0; 
			 }
		
			 if(results.returnval>0)
			 {
				$scope.returnval=results.returnval;
			 }else{
				$scope.returnval=0; 
			 }
		
			 if(results.shelve>0)
			 {
				$scope.shelve=results.shelve;
			 }else{
				$scope.shelve=0; 
			 }
		
			 if(results.shipment_forward_arrival>0)
			 {
				$scope.shipment_forward_arrival=results.shipment_forward_arrival;
			 }else{
				$scope.shipment_forward_arrival=0; 
			 }
		
			 if(results.holdfor_pickup>0)
			 {
				$scope.holdfor_pickup=results.holdfor_pickup;
			 }else{
				$scope.holdfor_pickup=0; 
			 }
		
			 if(results.pod>0)
			 {
				$scope.pod=results.pod;
			 }else{
				$scope.pod=0; 
			 }
			 
			 if(results.received_inbound>0)
			 {
				$scope.received_inbound=results.received_inbound;
			 }else{
				$scope.received_inbound=0; 
			 }
		
			 if(results.readyfor_delivery>0)
			 {
				$scope.readyfor_delivery=results.readyfor_delivery;
			 }else{
				$scope.readyfor_delivery=0; 
			 }
		 


		 });
	};
	
	$scope.GetexportData=function()
	{
		
		Data.post('ShipmentManagement/GetshipmentExportDataaHome').then(function (results) {
			console.log(results);
		})
	}
	$scope.GetshowmonthlyinsideData=function()
	{
		
		Data.post('ShipmentManagement/GetshowmonthlyinsideData').then(function (results) {
			//alert(results.title1);
					var totalVisitors = 883000;
		var visitorsData = {
	"New vs Returning Visitors": [{  
		innerRadius: "75%",
		legendMarkerType: "square",
		name: "New vs Returning Visitors",
		radius: "100%",
		showInLegend: true,
		startAngle: 90,
		type: "doughnut",
		dataPoints: [ 
	
	 
			  { y:parseInt(results.title1), name: "New Shipment", color: "#26A69A" },
			{ y: parseInt(results.title2), name: "Not Delivered", color: "#EC407A" },
			{ y: parseInt(results.title3), name: "Not Delivered", name: "Pick Up Collected", color: "#42A5F5" },
			{ y: parseInt(results.title4), name: "Out for delivery", color: "#FF7043" },
			{ y: parseInt(results.title5), name: "Return", color: "#26C6DA" },
			{ y: parseInt(results.title6), name: "Shelve", color: "#9CCC65" },
			{ y: parseInt(results.title7), name: "Shipment Forward  Arrival ", color: "#26A69A" },
			{ y: parseInt(results.title8), name: "Hold for pickup ", color: "#7E57C2" },
			{ y: parseInt(results.title9), name: "POD", color: "#AB47BC" },
			{ y: parseInt(results.title10), name: "Received Inbound ", color: "#777" },
			{ y:parseInt(results.title11), name: "Ready For Delivery ", color: "#8D6E63" }
		]
	}], 
};

var newVSReturningVisitorsOptions = {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "All Data"
	}, 
	legend: {
		fontFamily: "calibri",
		fontSize: 14,
		itemTextFormatter: function (e) {
			return e.dataPoint.name + ": " + Math.round(e.dataPoint.y) + "";  
		}
	},
	data: []
};

var visitorsDrilldownedChartOptions = {
	animationEnabled: true,
	theme: "light2",
	axisX: {
		labelFontColor: "#717171",
		lineColor: "#a2a2a2",
		tickColor: "#a2a2a2"
	},
	axisY: {
		gridThickness: 0,
		includeZero: false,
		labelFontColor: "#717171",
		lineColor: "#a2a2a2",
		tickColor: "#a2a2a2",
		lineThickness: 1
	},
	data: []
};

var chart = new CanvasJS.Chart("chartContainer1", newVSReturningVisitorsOptions);
chart.options.data = visitorsData["New vs Returning Visitors"];
chart.render();
		})
		
	}
	
	$scope.showdashboardgraph=function()
	{ 
	
	Data.post('ShipmentManagement/GetmonthlyGraphData').then(function (results) {
		//console.log(results);
  //var titleval1= $scope.GetshowmonthlyinsideData('booked',1);
 // alert($scope.GetshowmonthlyinsideData('booked',1));
	$(".chartContainer").CanvasJSChart({ 
		title: { 
			text: "Monthly Shipment Details" 
		}, 
		axisY: { 
			title: "Total Shipment", 
			suffix: "",  
		}, 
		data: [ 
		{ type: "column", 
			toolTipContent: "{label}: {y} Shipment",
		dataPoints: results}]}); 
		
		

 
	})
 
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
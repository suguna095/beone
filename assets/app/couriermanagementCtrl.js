app.controller('couriermanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams,Excel,$timeout,$sce) {
	
		
    //initially set those objects to null to avoid undefined error
    $scope.viewcourierData = [];
	$scope.filterData={};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
	$scope.viewOdoDatalist=[];
    $scope.editcourierArray = {};
    $scope.courierArray = {};
	$scope.editodoArray={};
	$scope.cityDropArr={};
	$scope.shelveDropArr={};
	$scope.supplierDropArr={};
	$scope.UpdateData={};
	//alert("ssssss");
	$scope.searchResult =[];
   
   angular.element(document).ready(function () {
    
	 $( "#datepicker1" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	 $( "#datepicker2" ).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	
	 
    });
   
   
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
$scope.viewcourier = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewcourierData=[];
		  }
		   Data.post('CouriersManagement/show_couriers',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.viewcourierData.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};

$scope.EditCouriershow=function(custdata)
	{
		
		Data.post('CouriersManagement/ShowEditcourier', {courierid:$stateParams.courierid}).then(function (results) {
			console.log(results);
			$scope.editcourierArray=results; 
			$scope.editcourierArray.courierid= $stateParams.courierid;
            $scope.editcourierArray.city=$scope.editcourierArray.cityname; 
             $scope.editcourierArray.supplier=$scope.editcourierArray.supplier;			
        });
	};

	$scope.Editodometershow=function(custdata)  
	{
		
		Data.post('CouriersManagement/Showodometer', {courierid:$stateParams.courierid}).then(function (results) {
			console.log(results);
			$scope.editcourierArray=results; 
			$scope.editcourierArray.courierid= $stateParams.courierid;

        });
	};


$scope.AssignRootshow=function(custdata)
	{
		Data.post('CouriersManagement/ShowAssignRoot', {courierid:$stateParams.courierid}).then(function (results) {
			console.log(results);
			$scope.editcourierArray=results.result; 
			$scope.editcourierArray.courierid= $stateParams.courierid; 
        });
	};
	
	$scope.GetCourierdelete = function(cor_id)
	{
		
        Data.post('CouriersManagement/get_delete_courier', {cor_id:cor_id}).then(function (results) { 
		console.log(results);
		alert("Deleted Successfully");
		  $state.reload();  
        });
    };

   $scope.Courierform = function (add_couriers) {
		//console.log(add_courier);
        Data.post('CouriersManagement/AddCourier', {
            add_couriers: add_couriers
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Added Successfully");
				$state.go('show_couriers');	 
				
            }
			else if (results== 'false'){
				
					alert("all field are required");  
			}
				
			else{
				alert("Email Id is Already Exist");
			
			}
        });
    };

    $scope.EditCourierform = function (edit_couriers) {
	    //console.log(edit_couriers);  
        Data.post('CouriersManagement/AddEditCourier', {
            edit_couriers: $scope.editcourierArray
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully");
				$state.go('show_couriers'); 
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	
	 $scope.GetupdatePrivilageData = function (onoff_true_false,courierid,root_id) {
		// alert(root_id);
		 $scope.UpdateData.onoff_true_false=onoff_true_false;
		 $scope.UpdateData.courierid=courierid;
		  $scope.UpdateData.root_id=root_id;
		
		   Data.post('CouriersManagement/setAssignRoot',$scope.UpdateData).then(function (results) { 
			console.log(results);
			  if (results== 'true') {
				alert("Route Asigned !");
				$state.go(); 
				
            }
			else
			{
				alert("Route Unsigned !");
					$state.go(); 
			}
			
        });  
	 }
	 
	 
	$scope.viewOdoDetails = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.viewOdoDatalist=[];
		  }
		   Data.post('CouriersManagement/show_Odo',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.viewOdoDatalist.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			}); 
			
		};
		
		$scope.EditOdoData=function(custdata)
	{
		
		Data.post('CouriersManagement/ShowEditOdo', {odoid:$stateParams.odoid}).then(function (results) {
		//	console.log(results);
			$scope.editodoArray=results;
			$scope.editodoArray.odoid= $stateParams.odoid;

        });
	};
	
	 $scope.EditOdoform = function (edit_odo) {
	    //console.log(edit_odo);  
        Data.post('CouriersManagement/AddEditodo', {
            edit_odo: $scope.editodoArray
        }).then(function (results) {
			//console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('odometer_details'); 
				
            }
			else
			{
				alert("all field are required"); 
			//$scope.errormess=results.error;
			}
        });
    };
	
	$scope.ShowCourierCityDrop=function()
	{
	 Data.post('CouriersManagement/CourierCityDrop').then(function (results) {
		//	console.log(results);
			$scope.CourierCityArray=results;
	 });
	};
	
	$scope.ShowCourierVehicleDrop=function()
	{
	 Data.post('CouriersManagement/CourierVehicleDrop').then(function (results) {
		//	console.log(results);
			$scope.CourierVehicleDropArray=results;
	 });
	};
	
	$scope.ShowCourierSupplierDrop=function()
	{
	 Data.post('CouriersManagement/CourierSupplierDrop').then(function (results) {
		//	console.log(results);
			$scope.supplierDropArr=results;
	 });
	};
	
	
	$scope.ShowCoractiveStatus = function (cor_id,online_offline_status) {
		//alert(cor_id);
        Data.post('CouriersManagement/GetCourtatusUpdate', {cor_id:cor_id,online_offline_status:online_offline_status}).then(function (results) { 
			console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };

    $scope.GetCountryDropshow=function()
	{
		
	Data.post('CouriersManagement/GetCountryDropshowShow').then(function (results) {
			console.log(results);
			
			$scope.CountryData=results;
	 });	
	};
	$scope.Getcitydropdata=function(country_id)
	{
		disableScreen(1);
		$scope.loadershow=true;
	Data.post('CouriersManagement/Getcitydropdatashow',{country_id:country_id}).then(function (results) {
			console.log(results);
			disableScreen(0);
		    $scope.loadershow=false;
			$scope.cityDropArr=results;
			$scope.shelvearray=[];
				angular.forEach($scope.cityDropArr, function(results){
					$scope.shelvearray.push(results.city);       
				});
				
				var input = document.getElementById("show_city_dropdown");
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;
				console.log($scope.shelvearray);
	 });	
	};

function Getloginalerttrue1(title,mess,type,icon)
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
	  url: 'CouriersManagement/courierImport',
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
		Getloginalerttrue1("Alert",$scope.alretData,"orange","fa fa-warning");   
	
	  }
	  else
	    Getloginalerttrue1("Error",'please select file',"orange","fa fa-warning");    
	  
	 });
	};

     $scope.exportToExcel = function (print) { // ex: '#my-table'
    

           var exportHref = Excel.tableToExcel(print, 'sheet name');
            $timeout(function () { location.href = exportHref; }, 100); // trigger download 
        }
		
		$scope.exportToExcel1 = function (prints) { // ex: '#my-table'
    

           var exportHref = Excel.tableToExcel(prints, 'sheet name');
            $timeout(function () { location.href = exportHref; }, 100); // trigger download 
        }

});

app.factory('Excel', function ($window) {
    var uri = 'data:application/vnd.ms-excel;base64,',
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) { return $window.btoa(unescape(encodeURIComponent(s))); },
        format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) };
    return {
        tableToExcel: function (tableId, worksheetName) {
            var table = $(tableId),
                ctx = { worksheet: worksheetName, table: table.html() },
                href = uri + base64(format(template, ctx));
            return href;
        }
    };
})

app.directive('ngFile', ['$parse', function ($parse) {
 return {
  restrict: 'A',
  link: function(scope, element, attrs) {
   element.bind('change', function(){

    $parse(attrs.ngFile).assign(scope,element[0].files)
    scope.$apply();
   });
  }
 };
}]);
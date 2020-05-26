app.controller('routemanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.RoutelistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchroute ="";
	 $scope.totalCount=0;
	$scope.routeArray={};
	$scope.editrouteArray={};
	$scope.RouteCityArray={};
	
	$scope.CountryData={};
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
	 $scope.getRoutelist = function (page_no,reset) {
		  disableScreen(1);
		 $scope.loadershow=true; 
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.RoutelistArray=[];
		  }
		   Data.post('RoutsManagement/showRoutelist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
			   disableScreen(0);
		 $scope.loadershow=false; 
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
                          $scope.RoutelistArray.push(value);

                        });
                    }
					else 
					{$scope.nodata=true
                    }
			});
		};
		
		$scope.getRoutelistExcel = function () {
		  
		   Data.post('RoutsManagement/showRoutelistExcel').then(function (results) {
			   $scope.ExcelArray=results;
			  
			});
		};
   
	$scope.GetRoutedelete = function (id) {
		//alert (id); 
        Data.post('RoutsManagement/get_delete_route', {id:id}).then(function (results) { 
			console.log(results);
			alert("Deleted Successfully");
			$state.reload();
		   
          // $scope.edit_compidArray=results;
        });  
    };
	
	$scope.AddRouteform = function (add_route) {
		  //console.log(add_route);
        Data.post('RoutsManagement/add_route', {
            add_route: add_route
        }).then(function (results) {
			console.log(results);    

            if (results== 'true') {
				// Data.toast(results);
				alert("Added Successfully");
				$state.go('show_route');	
				
            }
			else
				
			{
				alert("Already Exits");
			
			}
        });
    };
	
	$scope.EditRoutshow=function(custdata)
	{
		
		
		Data.post('RoutsManagement/geteditrouteData', {routeid:$stateParams.routeid}).then(function (results) {
			console.log(results);
			$scope.editrouteArray=results;       
			$scope.editrouteArray.routeid= $stateParams.routeid;
			$scope.ShowRouteCityDrop($scope.editrouteArray.country_id);
			$scope.editrouteArray.city_id=$scope.editrouteArray.cityname;  

        });
	};
	
	$scope.EditRouteform = function (edit_route) {
		//console.log(edit_route); 
        Data.post('RoutsManagement/edit_Routeform', {
            edit_route: $scope.editrouteArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Updated Successfully");
				$state.go('show_route');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	$scope.GetCountryDropshow=function()
	{
		
	Data.post('InventoryManagement/GetCountryDropshowShow').then(function (results) {
			console.log(results);
			$scope.CountryData=results;
	 });

 
	}
	$scope.ShowRouteCityDrop=function(country_id)
	{
		 disableScreen(1);
		 $scope.loadershow=true; 
	   Data.post('RoutsManagement/RouteCityDrop',{country_id:country_id}).then(function (results) {
			console.log(results);
		 disableScreen(0);
		 $scope.loadershow=false; 
			$scope.RouteCityArray=results;
			$scope.shelvearray=[];
				angular.forEach($scope.RouteCityArray, function(results){
					$scope.shelvearray.push(results.state);       
				});
				
				var input = document.getElementById("show_city_dropdown");
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;
				console.log($scope.shelvearray);


	 });
	};
	
	$scope.Warningshow={};
	$scope.UploadBulkRouteExcel= function(value){
	//alert("Hi");      
	var filedata=new FormData();
	angular.forEach($scope.uploadfiles,function(file){
	filedata.append('file',file);
   });
  //console.log(filedata);
   $http({
	method: 'post',
	url: 'RoutsManagement/UploadBulkUpExcel', 
	data: filedata,
	headers: {'Content-Type': undefined},
   }).then(function(response) { 
	console.log(response);
	if(response.data!='null')
	{
		
   ///var  filedata=[];
	$scope.Warningshow=response.data;
	 alert("Added Successfully");
   // $scope.getshelvelist(1,0);
   $state.reload()
	//$state.go('show_shelve'); 
	}
	else
	alert("please select file");
	
   });
  }   
});

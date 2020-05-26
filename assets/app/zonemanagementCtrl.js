app.controller('zonemanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
    $scope.ShowZoneArray=[];
	$scope.filterData = {};
	$scope.filterData.searchroute ="";
	$scope.totalCount=0;
	$scope.routeArray={};
	$scope.editzoneArray={}; 
	$scope.ShowCityZoneArray=[]; 
	$scope.ShowCountryZoneArray=[];
	$scope.editMessage=false;
	$scope.alphabetic=[];
	$scope.Citylist=[];
	$scope.CountryZonelist=[];
	$scope.nodata = false;
	 $scope.GetShowZoneList = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ShowZoneArray=[];
		  }
		   Data.post('ZoneManagement/showZonelist',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
                          $scope.ShowZoneArray.push(value);

                        });
                    }
					else 
					{$scope.nodata=true;
                    }
			});
		};
   
	
	$scope.AddZoneform = function (add_zone) { 
		  console.log(add_zone);
        Data.post('ZoneManagement/AddZone', {
            add_zone: add_zone
        }).then(function (results) {
			console.log(results);  //$state.reload();  
            if (results== 'true') {
				// Data.toast(results);
			alert("Successfully Inserted"); 
            }
			else
				
			{
				alert("Already Exists"); 
			
			}
			
			$scope.zoneArray="";
				$state.reload();
        });
	};
		$scope.EditZoneshow=function(custdata)
	{
		
		Data.post('ZoneManagement/ShowEditZones', {zid:custdata}).then(function (results) {
		console.log(results);
			$scope.zoneArray=results;
			$scope.zoneArray.zid=custdata;
            $scope.editMessage=true;
            $('#zone').focus();
        });
	};
  //$scope.editMessage=true;
	$scope.GetZonedelete = function (id) {
		//alert (id);   
        Data.post('ZoneManagement/get_delete_zone', {id:id}).then(function (results) { 
		alert("Successfully Deleted"); 
		$state.reload();
		//$scope.GetShowZoneList();  
		
        }); 
    };
	
	$scope.EditZoneform = function (add_zone) {
		//console.log(edit_zone); 
        Data.post('ZoneManagement/EditZone', {
            add_zone: add_zone 
        }).then(function (results) {
			console.log(results);
			alert("Successfully Updated"); 
		   	$scope.editMessage=false; 
				$scope.zoneArray="";
				$state.reload(); 
		 
        });
    };
	  
	 $scope.ShowCityZone = function (page_no,reset,alphabetic) {
		$scope.filterData.page_no=page_no;
		$scope.filterData.alphabetic=alphabetic;
		  if(reset==1)
		  {
		  $scope.ShowCityZoneArray=[];
		  }
		   Data.post('ZoneManagement/GetCityZone',$scope.filterData ).then(function (results) {
			   $scope.totalCount=results.count;
				$scope.alphabetic=alphabetic;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
							
                          $scope.ShowCityZoneArray.push(value);
						
                        });
                    }
					else 
					{$scope.nodata=true;
                    }
			});
		};
		
		
		 $scope.ShowCountryZone = function (page_no,reset,alphabetic) {
		$scope.filterData.page_no=page_no;
		$scope.filterData.alphabetic=alphabetic;
		  if(reset==1)
		  {
		  $scope.ShowCountryZoneArray=[];
		  }
		   Data.post('ZoneManagement/GetCountryZone',$scope.filterData ).then(function (results) {
			   $scope.totalCount=results.count;
				$scope.alphabetic=alphabetic;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value) 
						{
							
                          $scope.ShowCountryZoneArray.push(value);
						
                        });
                    }
					else 
					{$scope.nodata=true 
                    }
			});
		};
		
		
		 $scope.GetshowZoneDrop = function () {
			Data.post('ZoneManagement/showZoneDrop').then(function (results) { 
				// console.log(results);
				 
				 $scope.CityZonelist=results;
				 
				
			   // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
			 });
		 };
		
		
		 $scope.GetshowCountryZoneDrop = function () {
			Data.post('ZoneManagement/showCountryZoneDrop').then(function (results) { 
				// console.log(results);
				 
				 $scope.CountryZonelist=results;
				 
				
			   // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
			 });
		 };
		 
		 
		$scope.ShowCityZoneList = function () {
			Data.post('ZoneManagement/showCityDrop').then(function (results) { 
				// console.log(results);
				 
				 $scope.Citylist=results;
				 
				
			   // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
			 });
		 };
		 
		 $scope.ShowCityZoneByAlpha = function(shid) {
			alert(shid);
		 };
		 $scope.EditShipmentshow=function(custdata)
	{
		
		Data.post('ShipmentManagement/ShowEditShipment', {cusid:$stateParams.cusid}).then(function (results) {
			////console.log(results);
			$scope.editshipmentArray=results;
			$scope.editshipmentArray.cusid= $stateParams.cusid;

        });
	};
	
		 
	$scope.updatezone_id = function (zone_id,id) {
		console.log(zone_id,id);
			Data.post('ZoneManagement/GetZoneIDUpdate', {zone_id:zone_id,id:id}).then(function (results) { 
			console.log(results);
			alert("Updated Successfully");  
		    $state.reload();  
        });
		 };
		 		 
	$scope.updateCountryzone_id = function (country_zone_id,id) {
		console.log(country_zone_id,id);
			Data.post('ZoneManagement/GetCountryZoneIDUpdate', {country_zone_id:country_zone_id,id:id}).then(function (results) { 
			console.log(results);
			alert("Updated Successfully");  
		    $state.reload();  
        });
		 };
		 

		 
		 $scope.ShowZoneactiveStatus = function (id,status) {
		//alert(id);
        Data.post('ZoneManagement/GetZonestatusUpdate', {id:id,status:status}).then(function (results) { 
			console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };
}); 



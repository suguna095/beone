app.controller('staffmanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
   $scope.StafflistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
	$scope.routeArray={};
	$scope.editstaffArray={};
	$scope.originlist={};
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
	 $scope.getStafflist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.StafflistArray=[]; 
		  }
		   Data.post('StaffManagement/showStafflist',$scope.filterData).then(function (results) {
console.log(results);			  
			  $scope.totalCount=results.count;
				
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.StafflistArray.push(value);

                        });
                    }
					else  
					{$scope.nodata=true
                    }
			});
		};    
   
	
		
	$scope.GetStaffdelete = function (id) {
		//alert (id); 
        Data.post('StaffManagement/get_delete_staff', {id:id}).then(function (results) {   
			console.log(results);
			alert("Successfully Deleted");
			$state.reload();
		   
          // $scope.edit_compidArray=results;
        });
    };
	
	$scope.Addstaffform = function (add_staff) {
		  console.log(add_staff);
        Data.post('StaffManagement/add_staff', {
            add_staff: add_staff
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Successfully Added");
				$state.go('show_staff');	 
				
            }
			else if (results== 'false'){
				
					alert("all field are required");  
			}
				
			else{
				alert("Email Id is Already Exist");
			
			}
        });
    };
	
	$scope.Editstaffshow=function(custdata)
	{
		
		Data.post('StaffManagement/geteditstaffData', {staffid:$stateParams.staffid}).then(function (results) {
			console.log(results);
			$scope.editstaffArray=results;
			$scope.editstaffArray.staffid= $stateParams.staffid;
			$scope.showOriginDrop($scope.editstaffArray.country_id);
			$scope.editstaffArray.branch_location=$scope.editstaffArray.cityname;  

        });
	}; 
	
	$scope.EditStaffform = function (edit_staff) {
	    console.log(edit_staff);  
        Data.post('StaffManagement/edit_staffform', {
            edit_staff: $scope.editstaffArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Successfully Updated");
				$state.go('show_staff');
				
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
		//alert("ssssss");
	Data.post('InventoryManagement/GetCountryDropshowShow').then(function (results) {
			console.log(results);
			$scope.CountryData=results;
	 });	
	}
	$scope.showOriginDrop = function (country_id) {
		disableScreen(1);
		 $scope.loadershow=true;
			Data.post('RoutsManagement/RouteCityDrop',{country_id:country_id}).then(function (results) { 
				 console.log(results);
				 disableScreen(0);
		        $scope.loadershow=false;
				 $scope.originlist=results;
				$scope.shelvearray=[];
				angular.forEach($scope.originlist, function(results){
					$scope.shelvearray.push(results.state);      
				});
				
				var input = document.getElementById("show_city_dropdown");
				var awesomplete = new Awesomplete(input);

				/* ...more code... */

				awesomplete.list =$scope.shelvearray;
				console.log($scope.shelvearray);


			 });
		 }; 
	$scope.ShowactiveStatus = function (id,status) {
		
        Data.post('StaffManagement/GetstaffstatusUpdate', {id:id,status:status}).then(function (results) { 
			console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };	 
});

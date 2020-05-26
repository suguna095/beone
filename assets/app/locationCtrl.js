app.controller('locationCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams,Excel, $timeout) {
   
   //alert(ssssss);
	
$scope.AddCityList = function (add_cityr) {
	
		  //console.log(add_cityr);
        Data.post('LocationrManagement/AddCityListr', {
            add_cityr: add_cityr
        }).then(function (results) {
			console.log(results);    

            if (results== 'true') {
				// Data.toast(results);
				
					alert("City Added Successfully"); 
					$state.go($state.current, {}, {reload: true}); 
				
            }
			else
				
			{
				alert("all field are required"); 
			
			}
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
		   
		   
	$scope.AddCountryList = function (add_country) {
	
		  //console.log(add_cityr);
        Data.post('LocationrManagement/AddCountryList', {
            add_country: add_country
        }).then(function (results) {
			console.log(results);    

            if (results== 'true') {
				// Data.toast(results);
				    
					alert("Country Added Successfully"); 
				$state.go('location_list');
            }
			else
				
			{
				alert("all field are required"); 
			
			}
        });
    }
	
	$scope.AddStateList = function (add_state) {
	
		  //console.log(add_cityr);
        Data.post('LocationrManagement/AddStaeList', {
            add_state: add_state
        }).then(function (results) {
			console.log(results);    

            if (results== 'true') {
				// Data.toast(results);
				
					alert("State Added Successfully"); 
				$state.reload();
            }
			else
				
			{
				alert("all field are required"); 
			
			}
        });
    }
	
	$scope.ShowcountrylistArrar=[];
	$scope.filterData = {};
	$scope.ViewCountryList = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ShowcountrylistArrar=[];
		  }
		   Data.post('LocationrManagement/showCountryList',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ShowcountrylistArrar.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
		
		
		$scope.ViewCountryListAll=function(custdata)
	{
		
		Data.post('LocationrManagement/showCountryAll', {country:$stateParams.country}).then(function (results) {
		console.log(results);
			$scope.ShowAllcountryList=results;
			$scope.ShowAllcountryList.country= $stateParams.country;

        });
	};
	
		
		
		
		$scope.CourierCityArray={};
		$scope.ShowCourierCityDrop=function()
	{
	 Data.post('LocationrManagement/CourierCityDrop').then(function (results) {
		//	console.log(results);
			$scope.CourierCityArray=results;
	 });
	};
	
	$scope.Countrydatadelete = function(id)
	{
		//alert(id);
        Data.post('LocationrManagement/CountryDelete', {id:id}).then(function (results) { 
		console.log(results);
		alert("Country Deleted Succeessfully");
		  $state.reload();  
        });
    }
	
	$scope.CountryAlldatadelete = function(id)
	{
		//alert(id);
        Data.post('LocationrManagement/CountryDelete', {id:id}).then(function (results) { 
		console.log(results);
		alert("Country Deleted Succeessfully");
		  $state.reload();  
        });
    }
	
		$scope.ShowactiveStatus = function (id,cstatus) {
		
        Data.post('LocationrManagement/GetCountrystatusUpdate', {id:id,cstatus:cstatus}).then(function (results) { 
			console.log(results);
			//alert(sssss);  
		    $state.reload();  
        });
    };
	$scope.EditCountryshow=function(custdata)
	{
		
		Data.post('LocationrManagement/ShowEditCountry', {id:$stateParams.id}).then(function (results) {
		//console.log(results);
			$scope.editCountryArray=results;
			$scope.editCountryArray.id= $stateParams.id;

        });
	};
	
	$scope.UpdateCountryform = function (edit_country) {
	    //console.log(edit_customer);  
        Data.post('LocationrManagement/UpdateCountryList', {
            edit_country: $scope.editCountryArray  
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
					alert("Country Updated Succeessfully");
				$state.go('location_list');
				
            }
			else if (results== 'false'){
				
					alert("all field are required");  
			}
				
			else{
				alert("Email Id is Already Exist");
			
			}
        });
    };
	
	$scope.UpdateEditCityform = function (edit_city) {
	    //console.log(edit_customer);  
        Data.post('LocationrManagement/UpdateCityListr', {
            edit_city: $scope.editCountryArray  
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
					alert("City Updated Succeessfully");
				$state.go('edit_city');
				
            }
			else if (results== 'false'){
				
					alert("all field are required");  
			}
				
			
        });
    };
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
	 
	 
	 $scope.upload = function(value){
		 //alert('Hi');
		  disableScreen(1);
		 $scope.loadershow=true; 
		  var filedata=new FormData();
		  angular.forEach($scope.uploadfiles,function(file){
		  filedata.append('file',file);
		 });
//console.log(filedata);
	   $http({
	  method: 'post',
	  url: 'LocationrManagement/CountryImportsrates',
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

app.controller('generalsettingCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
    //initially set those objects to null to avoid undefined error
    
   
    $scope.uploadappData = {};
	
	$scope.upload_appArray = {};
	$scope.payment_settingArray={};
	$scope.socialArray = {};
	$scope.paymentArray = {};
	$scope.adminArray = {};
	$scope.companyArray = {};
    $scope.generalArray = {};
	$scope.smtpArray = {};
	$scope.editArray={};
	//alert("ssssss");
$scope.download = function() {
      $http.get('https://unsplash.it/200/300', {
          responseType: "arraybuffer"
        })
        .success(function(data) {
          var anchor = angular.element('<a/>');
          var blob = new Blob([data]);
          anchor.attr({
            href: window.URL.createObjectURL(blob),
            target: '_blank',
            download: 'fileName.png'
          })[0].click();
        })
    }
  
  
  
    $scope.showuploadapp = function () {
       Data.get('GeneralSetting/showUploadAppData').then(function (results) {
			console.log(results);
			
		    $scope.uploadappData=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
    
	
    $scope.company = function () {
       Data.get('GeneralSetting/showCompanyDetails').then(function (results) {
			console.log(results);
			
		    $scope.generalArray=results;
            $scope.companyArray=$scope.generalArray['company'][0];
            $scope.adminArray=$scope.generalArray['user'][0];
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
    
	//alert("ssssss");
    $scope.Addform = function (upload_app) {
        Data.post('GeneralSetting/upload_app', {
            upload_app: upload_app
        }).then(function (results) {
			console.log(results);
		   
		   $state.reload();
		   
            if (results == "true") {
				// Data.toast(results);
				
				$state.reload();
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
   
    
	
    $scope.socialform = function (social_detail) {
        Data.post('GeneralSetting/social_detail', {
            social_detail: social_detail
        }).then(function (results) {
			console.log(results);
		   
            if (results== "true") {
				// Data.toast(results);
				
				$state.reload(); 	
            }
			else
			{
				alert("all field are required");
			
			}
        });
	};
		
		$scope.paymentform = function (payment_setting) {
        Data.post('GeneralSetting/payment_setting', {
            payment_setting: payment_setting
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.go('upload_app');	
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	
	
	$scope.userform = function (admin) {
        Data.post('GeneralSetting/admin', {
            admin: admin
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				alert("Password Updated!"); 
				//$state.reload();	
            }
			else
				
			{
				alert("Already Exists");  
			
			}
        });
    };
	
	$scope.companyform = function (company) {
		console.log(company);
     Data.post('GeneralSetting/company', { 
            company: company
        }).then(function (results) {  
			console.log(results);
		   
            if (results== "true") { 
				// Data.toast(results);
				alert("Details Updated!"); 
				$state.reload();	
            }  
			else
				   
			{
				alert("all field are required");
			
			}
        });
    };  
	
	$scope.smtpform = function (smtp) {
        Data.post('GeneralSetting/smtp', {
            smtp: smtp
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.reload();	
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	$scope.Addfed = function (feed) {
        Data.post('GeneralSetting/addfeed', {
            feed: feed
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.go('show_testimonial');	    
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	
	 $scope.showtestimonial = function () {
       Data.get('GeneralSetting/showtestimonial').then(function (results) {
			console.log(results);
			
		    $scope.showtestimonial=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	
	
	 $scope.sayHi = function() {
    alert('hi!')
  }
	
	 $scope.showabout = function () {
       Data.get('GeneralSetting/showabout').then(function (results) {
			console.log(results);
			
		    $scope.showabout=results;
			
		   
          // $window.sessionStorage.setItem("adminID",results.udata.localSession.A_ID);
        });
    };
	
	$scope.GetAppdelete = function (id) {
		//alert (id); 
        Data.post('GeneralSetting/get_delete_app', {id:id}).then(function (results) { 
			console.log(results);
		    $state.reload();
        });
    };
	
	$scope.showeditaboutus=function(custdata)
	{
		
		Data.post('GeneralSetting/geteditaboutData', {rid:$stateParams.rid}).then(function (results) {
		//	console.log(results);
			$scope.abtArray=results;
			$scope.abtArray.rid= $stateParams.rid; 

        });
	};
	
	 $scope.Addformabts = function (abtus) {
		//console.log(news);
        Data.post('GeneralSetting/Abtusupdate', {
            abtus: $scope.abtArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_about_us');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
	
	$scope.GetAbtsdelete = function (id) {
		//alert (id); 
        Data.post('GeneralSetting/get_delete_test', {id:id}).then(function (results) { 
			console.log(results);
		    $state.reload();
        });
    };
	
	$scope.GetTestsdelete = function (id) {
		//alert (id); 
        Data.post('GeneralSetting/get_delete_abts', {id:id}).then(function (results) { 
			console.log(results);
		    $state.reload();
        });
    };
	
});

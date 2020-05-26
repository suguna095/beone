var app =angular.module('myApp', ['ui.router','ngResource','elif','ngRoute','ckeditor','pascalprecht.translate','ngSanitize'])



.controller('MainCtrl', function($scope,$http,$state,$location,$window,$translate) {
	
	if($window.localStorage.getItem('lang')=='en')
	{
		$translate.use('en');
		$scope.dir='LTR';
	}
	else if($window.localStorage.getItem('lang')=='ar')
	{
		$translate.use('ar');
		 $scope.dir='RTL';
	}
	else
	{
		$translate.use('en');
		$scope.dir='LTR';
	}
    //alert('xxxx');
	
	//console.log($state);
    //console.log($state.current);
//    angular.element(document).ready(function () {
//        
//   //alert($window.localStorage.getItem('lang'));
//    if( $window.localStorage.getItem('lang')==undefined)
//    {
//        $translate.use('en');
//        console.log('undef');
//        $scope.dir='LTR';
//    }
//    else
//    {
//        console.log('def');
//        $scope.language=$window.localStorage.getItem('lang');
//        $translate.use($scope.language);
//        if($scope.language=='en')
//        $scope.dir='LTR';
//        else
//        $scope.dir='RTL';
//    }
//});
  //  $scope.languageChange('default');
  
 // $translate.use('en');
	$scope.languageChange = function(lang){   
	//console.log(lang);
		
        $window.localStorage.setItem('lang',lang);
       
        $scope.language=$window.localStorage.getItem('lang');
		$translate.use($scope.language);
		if(lang=='en')
		 $scope.dir='LTR';
		 else if(lang=='ar')
		 $scope.dir='RTL';
		 else
		 $scope.dir='LTR';
        //$translate.use($scope.language);
        //if($scope.language=='en')
        //$scope.dir='LTR';
      //  else
       // $scope.dir='RTL';
	}
	
	
	
	$scope.showDialog = function () {
		$scope.isPanelVisible = true;
		bodyElement.classList.add('noscroll');
	};
	$scope.hideDialog = function () {
		$scope.isPanelVisible = false;
		bodyElement.classList.remove('noscroll');
	};
	$scope.GetResultEnterTacking=function(val){
		var result = { shid:val};
		$state.go('tracking_details', result);  
    }
    $scope.GetResultEnterTacking1=function(val){
		var result = { shid:val};
		$state.go('tracking_result', result);
	}
    $scope.authchek=true; 
   
   
	 $scope.togglePassword = function () { $scope.typePassword = !$scope.typePassword; };
     $scope.togglePasswordConf = function () { $scope.typePasswordConf = !$scope.typePasswordConf; };
	$scope.logout = function () {
		 $http({
		url: "Login/destorylogin",
		method: "POST",
		data:$scope.filterData,
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		
	}).then(function (response) {
          // $state.go('/');
		 $window.sessionStorage.setItem("adminID","");
		   $window.location="";
	})
       
           // Data.toast(results);
           // $location.path('login');
		   //$window.location="login";
        
    }
	
	
	})


.config(function($stateProvider, $routeProvider,$locationProvider,$translateProvider) {
 //$scope.baseUrl = new $window.URL($location.absUrl()).origin;
    // default route
	
	$translateProvider.useStaticFilesLoader({
	prefix: 'locales/local-',
	suffix: '.json'
	});
$translateProvider.preferredLanguage('ar');
	
    $routeProvider.otherwise("/");
	
	
	//=================header==================//
  var header = {
       templateUrl: 'application/views/includes/header.html',
       controller: function($scope) {}
     }
	 //===================footer======================//
     var footer = {
       templateUrl: 'application/views/includes/footer.html',
       controller: function($scope) {}
  
  }
  //=============routing===========================//
    // ui router states
    $stateProvider
	.state('/', {
            url: "/",
            views: {
                loginpage: {
                     templateUrl: 'application/views/login.html',
                     controller: 'authCtrl'
                }
            }
        })
        .state('dashboard', {
            url: "/dashboard",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/dashboard.html',
                    controller: 'authCtrl'
                },
                footer: footer
            }
        })
		.state('upload_app', {
            url: "/upload_app",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/upload_apps.html',
                   controller: 'generalsettingCtrl' 
                },
                footer: footer
            }
        }).state('company_details', {
            url: "/company_details",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/company_details.html',
                   controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        }).state('social_details', {
            url: "/social_details",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/social_details.html',
                   controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        })
		.state('smtp_configuration', {
            url: "/smtp_configuration",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/smtp_configuration.html',
                   controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        })
		.state('payment_setting', {
            url: "/payment_setting",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/payment_setting.html',
                   controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        })
		.state('show_testimonial', {
            url: "/show_testimonial",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/show_testimonial.html',
                   controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        })
		.state('add_feedback', {
            url: "/add_feedback",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/add_feedback.html',
                   controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        })
		.state('show_about_us', {
            url: "/show_about_us",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/show_about_us.html',
                   controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        })
		.state('edit_about_us', {     
            url: "/edit_about_us/:rid",  
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/generalsetting/edit_about_us.html',
                  controller: 'generalsettingCtrl'
                },
                footer: footer
            }
        })
		
		.state('ofd_issue', {
            url: "/ofd_issue",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/ofd_issue.html',
                   controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('order_not_picked', {
            url: "/order_not_picked",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/order_not_picked.html',
                   controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('shipments_hold', {
            url: "/shipments_hold",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/shipments_hold.html',
                   controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('csa_schedule_issue', {
            url: "/csa_schedule_issue",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/csa_schedule_issue.html',
                   controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('csa_location_issue', {
            url: "/csa_location_issue",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/csa_location_issue.html',
                   controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('driver_update', {
            url: "/driver_update",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/driver_update.html',
                  controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('future_update', {
            url: "/future_update",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/future_update.html',
                  controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('not_dispatch', {
            url: "/not_dispatch",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/operationfilter/not_dispatch.html',
                  controller: 'operationfilterCtrl'
                },
                footer: footer
            }
        })
		.state('all_shipment', {
            url: "/all_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/all_shipment.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		
		.state('getallshipments', {
            url: "/getallshipments/:search_type/:main_status/:shipmentStatus/:statusBy",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/getallshipments.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
        .state('view_shipment', {
            url: "/view_shipment/:shelv_no",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/all_shipment.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		
			.state('edit_shipment', {
            url: "/edit_shipment/:cusid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/edit_shipment.html',
                   controller: 'shipmentCtrl'   
                },
                footer: footer
            }
        })
		
			.state('details', {
            url: "/details/:shid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/details.html',
                   controller: 'shipmentCtrl'   
                },
                footer: footer
            }
        })
		
		.state('track_archive', {
            url: "/track_archive/:trackid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/track_archive.html', 
                   controller: 'shipmentCtrl'   
                },
                footer: footer
            }
        })
		
		
		
		
		.state('tracking_result', {
            url: "/tracking_result/:shid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/details.html',
                   controller: 'shipmentCtrl'   
                },
                footer: footer
            }
        })

        .state('tracking_details', {
            url: "/tracking_details/:shid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/tracking_details.html',   
                   controller: 'shipmentCtrl'        
                },
                footer: footer
            }
        })


		
		
		
			.state('edit_status', {
            url: "/edit_status/:cusid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/edit_status.html',
                   controller: 'shipmentCtrl'   
                },
                footer: footer
            }
        })
		
		
			.state('print_shipment', {
            url: "/print_shipment/:cusid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/print_shipment.php',
                   controller: 'shipmentCtrl'   
                },
                footer: footer
            }
        })
		
		
		.state('attachfile_shipment', {
            url: "/attachfile_shipment/:cusid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/attachfile_shipment.html',
                   controller: 'shipmentCtrl'   
                },
                footer: footer
            }
        })
		
		
		
		.state('archive_shipment', {
            url: "/archive_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/archive_shipment.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('add_new_shipment', {
            url: "/add_new_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/add_new_shipment.html',
                  controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('return_orders', {
            url: "/return_orders",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/return_orders.html',
                    controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('delivered_shipment', {
            url: "/delivered_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/delivered_shipment.html',
                    controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('deleted_shipment', {
            url: "/deleted_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/deleted_shipment.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('scanned_not_listed', {
            url: "/scanned_not_listed",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/scanned_not_listed.html',
                  controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('schedule_shipment1', {
            url: "/schedule_shipment1",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/schedule_shipment1.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('import_new_shipment', {
            url: "/import_new_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/import_new_shipment.html',
                    controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('import_return_shipment', {
            url: "/import_return_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/import_return_shipment.html',
                    controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('bulk_update', {
            url: "/bulk_update",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/bulk_update.html',
                    controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('assigning_shipments', {
            url: "/assigning_shipments",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/assigning_shipments.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('bulk_print', {
            url: "/bulk_print",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/bulk_print.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('ready_delivery_details', {
            url: "/ready_delivery_details/:uid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/ready_delivery_details.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('ready_delivery', {
            url: "/ready_delivery",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/ready_delivery.html',
                   controller:'shipmentCtrl'
                },
                footer: footer
            }
        })
		.state('add_bulk_scan', {
            url: "/add_bulk_scan",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bulkinvoicemanagement/add_bulk_scan.html',
                   controller:'bulkmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('cod_invoices', {
            url: "/cod_invoices",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bulkinvoicemanagement/cod_invoices.html',
                   controller: 'bulkmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('invoice_print', {
            url: "/invoice_print/:printid",   
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bulkinvoicemanagement/invoice_print.html',
                   controller: 'bulkmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('payable_invoices', {
            url: "/payable_invoices",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bulkinvoicemanagement/payable_invoices.html',
                   controller: 'bulkmanagementCtrl'
                },
                footer: footer
            }
        })
      .state('payableinvoice_print', {
            url: "/payableinvoice_print/:printid",   
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bulkinvoicemanagement/payableinvoice_print.html',
                   controller: 'bulkmanagementCtrl'
                },
                footer: footer
            }
        })
		
		 .state('payableCOD_print', {
            url: "/payableCOD_print/:printid",   
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bulkinvoicemanagement/payableCOD_print.html',
                   controller: 'bulkmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('payable_invoice_cod', {
            url: "/payable_invoice_cod", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bulkinvoicemanagement/payable_invoice_cod.html',
                   controller: 'bulkmanagementCtrl' 
                },
                footer: footer
            }
			
        })
		.state('operation_audit', {
            url: "/operation_audit",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/operation_audit.html',
                   controller: 'auditCtrl'
                },
                footer: footer
            }
        })
		.state('cs_audit', {
            url: "/cs_audit",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/cs_audit.html',
                   controller: 'auditCtrl'
                },
                footer: footer
            }
        })
		.state('view_audit', {
            url: "/view_audit",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/view_audit.html',
                   controller: 'auditCtrl'
                },
                footer: footer
            }
        })
		.state('add_reason', {
            url: "/add_reason",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/add_reason.html',
                   controller: 'auditCtrl' 
                },
                footer: footer
            }
        })
		.state('view_reason', {
            url: "/view_reason",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/view_reason.html',
                   controller: 'auditCtrl'
                },
                footer: footer
            }
        })
		.state('edit_reason', {
            url: "/edit_reason/:reid", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/edit_reason.html',
                   controller: 'auditCtrl'
                },
                footer: footer
            }
        })
		.state('call_record', {
            url: "/call_record",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/call_record.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('personal_call_record', {
            url: "/personal_call_record",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/audit/personal_call_record.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('generate_pickup', {
            url: "/generate_pickup",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/pickupmanagement/generate_pickup.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('scan_new_pickup', {
            url: "/scan_new_pickup",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/pickupmanagement/scan_new_pickup.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('bulk_pickup_update', {
            url: "/bulk_pickup_update",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/pickupmanagement/bulk_pickup_update.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('pickup_list', {
            url: "/pickup_list",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/pickupmanagement/pickup_list.html', 
                   controller: 'pickupmanagementCtrl'    
                },
                footer: footer
            }
        })
		.state('showpickup_detail', {
            url: "/showpickup_detail/:drs_unique_id", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/pickupmanagement/showpickup_detail.html',
                   controller: 'showpickupdetailCtrl'
                },
                footer: footer
            }
        })
		.state('create_location', {
            url: "/create_location",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/create_location.html',
                   controller: 'inventorymanagementCtrl'
                },
                footer: footer
            }
        })
		.state('manage_location', {
            url: "/manage_location",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/manage_location.html',
                   controller: 'inventorymanagementCtrl'
                },
                footer: footer
            }
        })
		.state('edit_location', {
            url: "/edit_location/:loid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/edit_location.html',
                   controller: 'inventorymanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('print_barcode', {
            url: "/print_barcode",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/print_barcode.html',
                   controller: 'inventorymanagementCtrl'
                },
                footer: footer
            }
        })
		.state('add_shelve', {
            url: "/add_shelve",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/add_shelve.html',
                   controller: 'inventorymanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('show_shelve', {
            url: "/show_shelve",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/show_shelve.html',
                   controller: 'inventorymanagementCtrl'    
                },
                footer: footer
            }
        })
		
		.state('edit_shelve', {
            url: "/edit_shelve/:sheid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/edit_shelve.html',
                   controller: 'inventorymanagementCtrl'    
                },
                footer: footer
            }
        })
		.state('inventory', {
            url: "/inventory",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/inventorymanagement/inventory.html',
                   controller: 'inventorymanagementCtrl'
                },
                footer: footer
            }
        })
		.state('add_manifest', {
            url: "/add_manifest",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/add_manifest.html',
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_manifest_detail', {
            url: "/show_manifest_detail/:manid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/show_manifest_detail.html',
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_manifest', {
            url: "/show_manifest",   
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/show_manifest.html',
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_not_found', {
            url: "/show_not_found/:nfoundid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/show_not_found.html',
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('return_manifest', {
            url: "/return_manifest",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/return_manifest.html',
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('bulk_manifest', {
            url: "/bulk_manifest",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/bulk_manifest.html',
                     controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('date_update1', {
            url: "/date_update1",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/date_update1.html',
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('line_haul', {
            url: "/line_haul",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/line_haul.html',
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('edit_line_haul', {
            url: "/edit_line_haul/:editid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/edit_line_haul.html', 
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('transit_time', {
            url: "/transit_time/:getid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/manifestmanagement/transit_time.html', 
                   controller: 'manifestmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('add_drs', {
            url: "/add_drs",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/deliveryrunsheet/add_drs.html',
                  controller: 'drsCtrl'
                },
                footer: footer
            }
        })
		.state('new_drs', {
            url: "/new_drs",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/deliveryrunsheet/new_drs.html',
                   controller: 'drsCtrl'
                },
                footer: footer
            }
        })
		.state('show_drs_detail', {
            url: "/show_drs_detail/:drs_unique_id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/deliveryrunsheet/show_drs_detail.html',
                     controller: 'drsDetailCtrl'  
                },
                footer: footer
            }
        })
		.state('show_drs', {
            url: "/show_drs",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/deliveryrunsheet/show_drs.html',
                   controller: 'drsCtrl'
                },
                footer: footer
            }
        })
		
		.state('delivery_detail', {
            url: "/delivery_detail/:drs_unique_id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/deliveryrunsheet/delivery_detail.html',
                     controller: 'drsDetailCtrl'  
                },
                footer: footer
            }
        })
		
		
		.state('notdelivery_detail', {
            url: "/notdelivery_detail/:drs_unique_id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/deliveryrunsheet/notdelivery_detail.html', 
                   controller: 'drsDetailCtrl'
                },
                footer: footer
            }
        })
		.state('scan_shipment', {
            url: "/scan_shipment",
            views: {  
                header: header,
                content: {
                     templateUrl: 'application/views/warehousemanagement/scan_shipment.html',
                   controller: 'warehouseCtrl' 
                },
                footer: footer
            }
        })
		.state('hold_shipment', {
            url: "/hold_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/warehousemanagement/hold_shipment.html',
                   controller: 'warehouseCtrl' 
                },
                footer: footer
            }
        })
		.state('schedule_shipment', {
            url: "/schedule_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/warehousemanagement/schedule_shipment.html',
                  controller: 'warehouseCtrl' 
                },
                footer: footer
            }
        })
		.state('bound_shipment', {
            url: "/bound_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/warehousemanagement/bound_shipment.html',
                  controller: 'warehouseCtrl' 
                },
                footer: footer
            }
			
        })
		.state('inventory_report', {
            url: "/inventory_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/warehousemanagement/inventory_report.html',
                   controller: 'warehouseCtrl' 
                },
                footer: footer
            }
        })
		.state('security_check', {
            url: "/security_check",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/warehousemanagement/security_check.html',
                   controller: 'warehouseCtrl' 
                },
                footer: footer
            }
        })
		.state('add_route', {
            url: "/add_route",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/routsmanagement/add_route.html',
                   controller: 'routemanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('add_services', {
            url: "/add_services",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/servicesmanagement/add_services.html',
                   controller: 'servicesmanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('edit_services', {
            url: "/edit_services/:id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/servicesmanagement/edit_services.html',
                   controller: 'servicesmanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('view_services', {
            url: "/view_services",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/servicesmanagement/view_services.html',
                   controller: 'servicesmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_route', {
            url: "/show_route",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/routsmanagement/show_route.html',
                   controller: 'routemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('edit_route', {
            url: "/edit_route/:routeid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/routsmanagement/edit_route.html',
                   controller: 'routemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_user', {
            url: "/show_user",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/usermanagement/show_user.html',
                   controller: 'usermanageCtrl'
                },
                footer: footer
            }
        })
		.state('add_staff', {
            url: "/add_staff",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/staffmanagement/add_staff.html',
                   controller: 'staffmanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('show_staff', {
            url: "/show_staff",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/staffmanagement/show_staff.html',
                   controller: 'staffmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('edit_staff', {
            url: "/edit_staff/:staffid", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/staffmanagement/edit_staff.html',
                   controller: 'staffmanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('edit_city', {
            url: "/edit_city/:id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/edit_city.html',
                   controller: 'locationCtrl' 
                },
                footer: footer
            }
        })
		
		.state('add_city', {
            url: "/add_city",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/add_city.html',
                   controller: 'locationCtrl' 
                },
                footer: footer
            }
        })
		
		.state('add_state', {
            url: "/add_state",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/add_state.html',
                   controller: 'locationCtrl' 
                },
                footer: footer
            }
        })
		
		.state('country_detail', {
            url: "/country_detail/:country",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/country_detail.html',
                   controller: 'locationCtrl' 
                },
                footer: footer
            }
        })
		
		.state('add_country', {
            url: "/add_country",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/add_country.html',
                   controller: 'locationCtrl' 
                },
                footer: footer
            }
        })
		
		.state('edit_country', {
            url: "/edit_country/:id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/edit_country.html',
                   controller: 'locationCtrl' 
                },
                footer: footer
            }
        })
		
		.state('location_list', {
            url: "/location_list",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/location_list.html',
                   controller: 'locationCtrl'
                },
                footer: footer 
            }
        })
		
		.state('import_hub', {
            url: "/import_hub",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/locationmanagement/import_hub.html',
                   controller: 'locationCtrl'
                },
                footer: footer
            }
        })
		.state('add_customer', {
            url: "/add_customer",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/add_customer.html',
                   controller: 'customermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_customer', {
            url: "/show_customer",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/show_customer.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('pay_info', {
            url: "/pay_info/:cusid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/pay_info.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		
		.state('view_shipments', {
            url: "/view_shipments/:booking_id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/view_shipments.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('customer_paymentdetails', {
            url: "/customer_paymentdetails/:cusid/:invoice_month_year",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/customer_paymentdetails.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('booking_details', {
            url: "/booking_details/:cusid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/booking_details.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('zone_rate', {
            url: "/zone_rate/:uniqueid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/zone_rate.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('weight_range', {
            url: "/weight_range/:uniqueid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/weight_range.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('edit_customer', {
            url: "/edit_customer/:cusid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/edit_customer.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('import_rates', {
            url: "/import_rates",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/import_rates.html',
                   controller: 'customermanagementCtrl'   
                },
                footer: footer
            }
        })
		.state('account_verification', {
            url: "/account_verification", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/customermanagement/account_verification.html',
                   controller: 'customermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('add_couriers', {
            url: "/add_couriers",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/add_couriers.html',
                   controller: 'couriermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_couriers', {
            url: "/show_couriers",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/show_couriers.html',
                   controller: 'couriermanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('edit_couriers', {
            url: "/edit_couriers/:courierid",  
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/edit_couriers.html',
                   controller: 'couriermanagementCtrl' 
                },
                footer: footer
            }
        })
		
		.state('drivers_details', {
            url: "/drivers_details/:courierid",  
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/drivers_details.html',
                   controller: 'couriermanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('odometer_details', {
            url: "/odometer_details",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/odometer_details.html',
                   controller: 'couriermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('edit_odo', {
            url: "/edit_odo/:odoid", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/edit_odo.html',  
                   controller: 'couriermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('odo_details', {
            url: "/odo_details/:courierid", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/odo_details.html',  
                   controller: 'couriermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('assign_route', {
            url: "/assign_route/:courierid", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couriersmanagement/assign_route.html',  
                   controller: 'couriermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('add_branch', {
            url: "/add_branch",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/branchmanagement/add_branch.html',
                   controller: 'branchmanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('show_branch', {
            url: "/show_branch",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/branchmanagement/show_branch.html',
                   controller: 'branchmanagementCtrl'  
                },
                footer: footer
            }
        })
		.state('edit_branch', {
            url: "/edit_branch/:branchid",   
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/branchmanagement/edit_branch.html',
                   controller: 'branchmanagementCtrl'  
                },
                footer: footer
            }
        })
		.state('supplier_report', {
            url: "/supplier_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/reports/supplier_report.html',
                    controller: 'reportCtrl'  
                },
                footer: footer
            }
        })
		.state('shipment_report', {
            url: "/shipment_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/reports/shipment_report.html',
                    controller: 'reportCtrl'  
                },
                footer: footer
            }
        })
		.state('transaction_report', {
            url: "/transaction_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/reports/transaction_report.html',
                   controller: 'reportCtrl'  
                },
                footer: footer
            }
        })
		.state('payment_report', {
            url: "/payment_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/reports/payment_report.html',
                    controller: 'reportCtrl'  
                },
                footer: footer
            }
        })
		.state('client_report', {
            url: "/client_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/reports/client_report.html',
                   controller: 'reportCtrl'  
                },
                footer: footer
            }
        })
		.state('hold_report', {
            url: "/hold_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/reports/hold_report.html',
                   controller: 'reportCtrl'  
                },
                footer: footer
            }
        })
		.state('rto_list', {
            url: "/rto_list",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/rtomanagement/rto_list.html',
                   controller: 'rtomanagementCtrl'
                },
                footer: footer
            }
        })
		.state('rto_detail', {
            url: "/rto_detail/:drs_unique_id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/rtomanagement/rto_detail.html',
                   controller: 'rtoDetailCtrl'
                },
                footer: footer
            }
        })

        .state('update_rto', {
            url: "update_rto/:drs_unique_id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/rtomanagement/update_rto.html',    
                     controller: 'rtoDetailCtrl'  
                },
                footer: footer
            }
        })  


		
		.state('pending_list', {
            url: "/pending_list",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/rtomanagement/pending_list.html', 
                   controller: 'rtomanagementCtrl'
                },
                footer: footer
            }
        })



        .state('getPrintlist', {
            url: "/getPrintlist/:start_date/:end_date",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/shipmentmanagement/printCOD.html',
                   controller: 'codmanagementCtrl'   
                },
                footer: footer
            }
        })

        .state('totalCOD', {
            url: "/totalCOD/:drs_unique_id/:codstatus",   
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/codmanagement/totalCOD.html',
                   controller: 'codmanagementCtrl'      
                },      
                footer: footer
            }
        })


		.state('confirm_shipment', {
            url: "/confirm_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/codmanagement/confirm_shipment.html',
                   controller: 'codmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('pending_shipment', {
            url: "/pending_shipment",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/codmanagement/pending_shipment.html',
                   controller: 'codmanagementCtrl'
                },
                footer: footer
            }
        })
		.state('new_coupon', {
            url: "/new_coupon",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couponmanagement/new_coupon.html',
                   controller: function($scope) {}
                },
                footer: footer
				
            }
        })
		.state('valid_coupon', {
            url: "/valid_coupon",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couponmanagement/valid_coupon.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('expire_coupon', {
            url: "/expire_coupon",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/couponmanagement/expire_coupon.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('ofd_report', {
            url: "/ofd_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/ofdreport/ofd_report.html',
                   controller: 'ofdCtrl'
                },
                footer: footer
            }
        })
		 
		
			.state('totalofd', {
            url: "/totalofd/:messanger_id/:drs_date/:drs_date2/:ofdstatus",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/ofdreport/totalofd.html',
                   controller: 'ofdCtrl'   
                },
                footer: footer
            }
        })


        .state('todayofd', {
            url: "/todayofd/:messanger_id/:drs_date/:ofdstatus",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/ofdreport/todayofd.html',
                   controller: 'ofdCtrl'   
                },
                footer: footer
            }
        })


		   .state('totalofddetails', {
            url: "/totalofddetails/:start_date/:end_date/:ofdstatus",
            views: {
                header: header,  
                content: {
                     templateUrl: 'application/views/ofdreport/totalofddetails.html',
                   controller: 'ofdCtrl'   
                },
                footer: footer
            }
        })
		
		.state('payment_details', {
            url: "/payment_details",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/paymentdetails/payment_details.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('invoice_management', {
            url: "/invoice_management",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/invoicemanagement/invoice_management.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('cod_report', {
            url: "/cod_report",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/invoicemanagement/cod_report.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('add_product_type', {
            url: "/add_product_type",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/producttype/add_product_type.html',
                   controller: 'producttypeCtrl'
                },
                footer: footer
            }
        })
		.state('show_product_type', {
            url: "/show_product_type",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/producttype/show_product_type.html',
                   controller: 'producttypeCtrl'
                },
                footer: footer
            }
        })
		.state('edit_product_type', {
            url: "/edit_product_type/:prid",  
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/producttype/edit_product_type.html',
                   controller: 'producttypeCtrl'
                },
                footer: footer
            }
        })
		.state('content_services', {
            url: "/content_services",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/contentservices/content_services.html',
                   controller: 'contentservicesCtrl'
                },
                footer: footer
            }
        })
		.state('edit_content_services', {
            url: "/edit_content_services/:conid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/contentservices/edit_content_services.html', 
                   controller: 'contentservicesCtrl'
                },
                footer: footer
            }
        })
		.state('cms_pages', {
            url: "/cms_pages",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/cmspages/cms_pages.html',
                   controller: 'cmsserviceCtrl'
                },
                footer: footer
            }
        })
     .state('edit_cms', {
            url: "/edit_cms/:id", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/cmspages/edit_cms.html',
                   controller: 'cmsserviceCtrl'
                },
                footer: footer
            }
        })
		.state('tickets', {
            url: "/tickets",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/tickets/tickets.html',
                   controller: 'ticketmanagementCtrl'  
                },
                footer: footer
            }
        })
		
		.state('ticket_reply', {
            url: "/ticket_reply/:id",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/tickets/ticket_reply.html', 
                   controller: 'ticketmanagementCtrl'  
                },
                footer: footer
            }
        })
		.state('newfeedback', {
            url: "/newfeedback",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/newfeedback/newfeedback.html',
                   controller: 'feedbackCtrl'
                },
                footer: footer
            }
        })
		.state('showrating', {
            url: "/showrating",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/showrating/showrating.html',
                   controller: 'showratingCtrl'
                },
                footer: footer
            }
        })
		.state('add_news', {
            url: "/add_news",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/news/add_news.html',
                   controller: 'newsCtrl'
                },
                footer: footer
            }
        })
		.state('edit_news', {
            url: "/edit_news/:editid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/news/edit_news.html',
                   controller: 'newsCtrl'
                },
                footer: footer
            }
        })
		.state('show_news', {
            url: "/show_news",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/news/show_news.html',
                   controller: 'newsCtrl'
                },
                footer: footer
            }
        })
		.state('add_notification', {
            url: "/add_notification",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/notification/add_notification.html',
                   controller: 'notificationCtrl'
                },
                footer: footer
            }
        })
		.state('show_notification', {
            url: "/show_notification",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/notification/show_notification.html',
                   controller: 'notificationCtrl'
                },
                footer: footer
            }
        })
		.state('edit_notification', {
            url: "/edit_notification/:notifyid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/notification/edit_notification.html',
                   controller: 'notificationCtrl'
                },
                footer: footer
            }
        })
		.state('show_location', {
            url: "/show_location",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/pickuplocation/show_location.html',
                   controller: 'pickupCtrl'
                },
                footer: footer
            }
        })
		.state('email_setting', {
            url: "/email_setting",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/emailtemplates/email_setting.html',
                   controller: 'emailtemplatesCtrl'
                },
                footer: footer
            }
		})
			.state('edit_email_setting', {
            url: "/edit_email_setting/:mailid", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/emailtemplates/edit_email_setting.html',
                   controller: 'emailtemplatesCtrl' 
                },
                footer: footer
            }
        })
		.state('featured_partners', {
            url: "/featured_partners",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/featuredpartners/featured_partners.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('seo', {
            url: "/seo",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/seo/seo.html',
					 
                   controller: 'seoCtrl'
                },
                footer: footer
            }
        })
		.state('edit_seo', {
            url: "/edit_seo/:seoid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/seo/edit_seo.html',
					 
                   controller: 'seoCtrl'
                },
                footer: footer
            }
        })
		.state('category_list', {
            url: "/category_list",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/productcategorylist/category_list.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('user_privilege', {
            url: "/user_privilege",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/setuserprivilege/user_privilege.html',
                   controller: 'setuserprivilegeCtrl' 
                },
                footer: footer
            }
        })
		.state('add_banner', {
            url: "/add_banner",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bannermanagement/add_banner.html',
                   controller: 'bannermanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('show_banner', {
            url: "/show_banner",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bannermanagement/show_banner.html',
                   controller: 'bannermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('edit_banner', {
            url: "/edit_banner/:banid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/bannermanagement/edit_banner.html',
                   controller: 'bannermanagementCtrl'
                },
                footer: footer
            }
        })
		.state('show_supplier', {
            url: "/show_supplier",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/outsourcemanagement/show_supplier.html',
                   controller: 'outsourcemanagementCtrl'
                },
                footer: footer
            }
        })
        .state('edit_supplier', {
            url: "/edit_supplier/:supid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/outsourcemanagement/edit_supplier.html',
                   controller: 'outsourcemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('generate_voice', {
            url: "/generate_voice",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/outsourcemanagement/generate_voice.html',
                   controller: 'outsourcemanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('add_supplier', {
            url: "/add_supplier",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/outsourcemanagement/add_supplier.html',
                   controller: 'outsourcemanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('payment_supplier', {
            url: "/payment_supplier/:id", 
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/outsourcemanagement/payment_supplier.html',
                   controller: 'outsourcemanagementCtrl' 
                },
                footer: footer
            }
        })
		.state('show_address', { 
            url: "/show_address",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/ams/show_address.html',
                   controller: 'amsCtrl' 
                },
                footer: footer
            }
        })
		.state('shipment_address', {
            url: "/shipment_address",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/ams/shipment_address.html',
                   controller: 'amsCtrl' 
                },
                footer: footer
            }
        })
		.state('new_address', {
            url: "/new_address",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/ams/new_address.html',
                   controller: 'amsCtrl'
                },
                footer: footer
            }
        })
		.state('cs_schedule', {
            url: "/cs_schedule",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/schedulemanagement/cs_schedule.html',
                   controller: 'schedulemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('blind_schedule', {
            url: "/blind_schedule",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/schedulemanagement/blind_schedule.html',
                   controller: 'schedulemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('bulk_reschedule', {
            url: "/bulk_reschedule",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/schedulemanagement/bulk_reschedule.html',
                   controller: 'schedulemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('schedule_remove', {
            url: "/schedule_remove",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/schedulemanagement/schedule_remove.html',
                   controller: 'schedulemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('date_update', {
            url: "/date_update",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/schedulemanagement/date_update.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		.state('pending_schedule', {
            url: "/pending_schedule",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/schedulemanagement/pending_schedule.html',
                   controller: function($scope) {}
                },
                footer: footer
            }
        })
		
		.state('zone_list', {
            url: "/zone_list",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/zonemanagement/zone_list.html',
                   controller: 'zonemanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('cityList', {
            url: "/cityList/:shid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/zonemanagement/cityList.html',
                   controller: 'zonemanagementCtrl'   
                },
                footer: footer
            }
        })
		
		
		.state('city_zone', {
            url: "/city_zone",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/zonemanagement/city_zone.html',
                   controller: 'zonemanagementCtrl'
                },
                footer: footer
            }
        })
		
		.state('country_zone', {
            url: "/country_zone",
            views: {
                header: header,
                content: {
                   templateUrl: 'application/views/zonemanagement/country_zone.html',
                   controller: 'zonemanagementCtrl'
                },
                footer: footer
            }
        })
		.state('add_faq', {
            url: "/add_faq",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/faq/add_faq.html',
                   controller: 'faqCtrl' 
                },
                footer: footer
            }
        })
		.state('edit_faq', {
            url: "/edit_faq/:faqid",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/faq/edit_faq.html',
                   controller: 'faqCtrl' 
                },
                footer: footer
            }
        })
		.state('show_faq', {
            url: "/show_faq",
            views: {
                header: header,
                content: {
                     templateUrl: 'application/views/faq/show_faq.html',
                   controller: 'faqCtrl'
                },
                footer: footer
            }
        });
		
		
       
		$locationProvider.html5Mode(true);
		
});

app.run(function ($rootScope, $state,Data,$window) {
	 $rootScope.lang = 'en';
	//alert("ssssss");
        $rootScope.$on("$stateChangeStart", function (event, next, current) {
			//alert("sssss");
			//console.log($state.$current);
			//console.log($state.current);
			$rootScope.adminID="";
			$rootScope.loginp =true;
            $rootScope.authenticated = false;
			//($window.sessionStorage.getItem('adminID'));
			//alert($window.sessionStorage.getItem('adminID'));
			//$window.sessionStorage.setItem("adminID","");
				//alert($rootScope.authenticated);
			//||  || $window.sessionStorage.getItem('adminID')=='null'
			
		
            Data.get('Login/getsession').then(function (results) {
				//alert("ssss");
				//console.log(results);
                if (results.status=="success") {
					
					 $window.sessionStorage.setItem("adminID",results.checklogin.A_ID);
					 
					$rootScope.adminID=$window.sessionStorage.getItem('adminID');
					$rootScope.loginp =false;
                    $rootScope.authenticated = true;
				   
                } else {
					//alert("sssss");
                    
                        $state.go('/');
                   
                }
            });
			//alert($window.sessionStorage.getItem('adminID'));
			if($window.sessionStorage.getItem('adminID26')!='LOG' && (!$window.sessionStorage.getItem('adminID') || $window.sessionStorage.getItem('adminID')=='null'))
			{
				//alert("ssssss");
				
				//$state.go('/');
				$window.sessionStorage.setItem("adminID26","LOG");
				  $rootScope.authenticated = false;
				//alert($rootScope.logincheck);
				$window.location="/";
			}
				
			
			//alert("sssss");
        });
    });
	app.run(function($rootScope, $timeout) {
    $rootScope.isVisible = {
        loading: false
    };
    $rootScope.$on("$stateChangeStart", function() {
        $rootScope.isVisible.loading = true;
        //alert($rootScope.isVisible.loading)
    });
    $rootScope.$on("$viewContentLoaded", function () {
        $timeout(function () {
            $rootScope.isVisible.loading = false;
            //alert($rootScope.isVisible.loading)
        }, 2000);
    });
});



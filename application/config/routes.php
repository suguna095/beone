<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'Home';

$route['dashboard'] = 'Home';

//General Setting
$route['upload_app'] = 'Home';
$route['company_details'] = 'Home';
$route['social_details'] = 'Home';
$route['smtp_configuration'] = 'Home';
$route['payment_setting'] = 'Home';
$route['show_testimonial'] = 'Home';
$route['add_feedback'] = 'Home';
$route['show_about_us'] = 'Home';
$route['edit_about_us/(:any)'] = 'Home'; 

//Operation Filter
$route['ofd_issue'] = 'Home';
$route['order_not_picked'] = 'Home';
$route['shipments_hold'] = 'Home';
$route['csa_schedule_issue'] = 'Home';
$route['csa_location_issue'] = 'Home';
$route['driver_update'] = 'Home';
$route['future_update'] = 'Home';
$route['not_dispatch'] = 'Home';


$route['awbArchievePrint/(:any)'] = 'ShipmentManagement/GetArchievelabelPrint4_6/$1';
$route['awbPrint/(:any)'] = 'ShipmentManagement/GetlabelPrint4_6/$1';
$route['awbPrintA4/(:any)'] = 'ShipmentManagement/GetlabelPrintA4/$1';
$route['bulkPrintAbw'] = 'ShipmentManagement/bulkPrintAbw';
$route['drsreadyforPrint/(:any)'] = 'ShipmentManagement/print_readyfordel/$1';
$route['drsforPrint/(:any)'] = 'DeliveryRunSheet/print_fordel/$1';
$route['rtoforPrint/(:any)'] = 'RtoManagement/print_rtol/$1'; 
$route['bulkInvoiceNumber/(:any)'] = 'BulkInvoiceManagement/bulkInvoiceNumber/$1';

$route['codreceivablePrint/(:any)'] = 'BulkInvoiceManagement/codreceivablePrint/$1';
$route['bulkPrintPayable/(:any)'] = 'BulkInvoiceManagement/bulkPrintPayableView/$1';

$route['printPickup/(:any)'] = 'PickupManagement/printPickupView/$1';
$route['printmanifestView/(:any)'] = 'ManifestManagement/printmanifestView/$1';
$route['printCOD/(:any)/(:any)'] = 'CodManagement/printCODList/$1/$2'; 
$route['printCOD'] = 'CodManagement/printCODList'; 
$route['printCODDetails/(:any)'] = 'CodManagement/GetlabelPrint4_6/$1';   
$route['codforPendingPrint/(:any)/(:any)'] = 'CodManagement/printPendingCOD/$1/$2'; 
$route['codforPendingPrint'] = 'CodManagement/printPendingCOD'; 
//Shipment Management
$route['all_shipment'] = 'Home';
$route['ready_delivery_details/(:any)'] = 'Home';
$route['archive_shipment'] = 'Home';
$route['add_new_shipment'] = 'Home';
$route['return_orders'] = 'Home';
$route['delivered_shipment'] = 'Home';
$route['deleted_shipment'] = 'Home';
$route['scanned_not_listed'] = 'Home';
$route['schedule_shipment1'] = 'Home';
$route['import_new_shipment'] = 'Home';
$route['import_return_shipment'] = 'Home';
$route['bulk_update'] = 'Home';
$route['assigning_shipments'] = 'Home';
$route['bulk_print'] = 'Home';
$route['ready_delivery'] = 'Home';
$route['details/(:any)'] = 'Home';
$route['getallshipments/(:any)/(:any)/(:any)/(:any)'] = 'Home';
$route['track_archive/(:any)'] = 'Home'; 


//Bulk Invoice Management
$route['add_bulk_scan'] = 'Home';
$route['cod_invoices'] = 'Home';
$route['payable_invoices'] = 'Home';
$route['payable_invoice_cod'] = 'Home';
$route['invoice_print/(:any)'] = 'Home';
$route['payableinvoice_print/(:any)'] = 'Home';
$route['payableCOD_print/(:any)'] = 'Home';
$route['notdelivery_detail/(:any)/(:any)'] = 'Home';
//audit
$route['operation_audit'] = 'Home';
$route['cs_audit'] = 'Home';
$route['view_audit'] = 'Home';
$route['add_reason'] = 'Home';
$route['view_reason'] = 'Home'; 
$route['call_record'] = 'Home';
$route['personal_call_record'] = 'Home';
$route['edit_reason/(:any)'] = 'Home'; 
$route['tracking_result/(:any)'] = 'Home'; 
$route['tracking_details/(:any)'] = 'Home'; 

//Pickup Management
$route['generate_pickup'] = 'Home';  
$route['scan_new_pickup'] = 'Home';
$route['bulk_pickup_update'] = 'Home';
$route['pickup_list'] = 'Home';
$route['showpickup_detail/(:any)'] = 'Home';  
 
 
//Inventory Management
$route['create_location'] = 'Home';
$route['manage_location'] = 'Home';
$route['print_barcode'] = 'Home';
$route['add_shelve'] = 'Home';
$route['show_shelve'] = 'Home';
$route['inventory'] = 'Home';
$route['edit_shelve/(:any)'] = 'Home';
$route['edit_location/(:any)'] = 'Home';
$route['view_shipment/(:any)'] = 'Home';  

//Manifest Management
$route['add_manifest'] = 'Home';
$route['show_manifest'] = 'Home';
$route['return_manifest'] = 'Home';
$route['bulk_manifest'] = 'Home';
$route['date_update1'] = 'Home';
$route['line_haul'] = 'Home';
$route['edit_line_haul'] = 'Home';
$route['transit_time'] = 'Home';
$route['transit_time/(:num)'] = 'Home';
$route['show_manifest_detail/(:any)'] = 'Home';  
$route['show_not_found/(:any)'] = 'Home';


   
//Delivery Run Sheet
$route['add_drs'] = 'Home';
$route['new_drs'] = 'Home';
$route['show_drs'] = 'Home';
$route['show_drs_detail/(:any)'] = 'Home'; 
$route['delivery_detail/(:any)/(:any)'] = 'Home'; 

//Warehouse Management
$route['scan_shipment'] = 'Home';
$route['hold_shipment'] = 'Home';
$route['schedule_shipment'] = 'Home';
$route['bound_shipment'] = 'Home';
$route['inventory_report'] = 'Home';
$route['security_check'] = 'Home';

//Routs Management
$route['add_route'] = 'Home';
$route['show_route'] = 'Home';
$route['edit_route/(:any)'] = 'Home'; 
//User Management
$route['show_user'] = 'Home';
//Staff Management
$route['add_staff'] = 'Home';
$route['show_staff'] = 'Home';
$route['edit_staff/(:any)'] = 'Home';
//Customer Management
$route['add_customer'] = 'Home';
$route['show_customer'] = 'Home';
$route['edit_customer/(:any)'] = 'Home';
$route['import_rates'] = 'Home';
$route['account_verification'] = 'Home';  
$route['pay_info/(:any)'] = 'Home';
$route['customer_paymentdetails/(:any)/(:any)'] = 'Home';
$route['booking_details/(:any)'] = 'Home';
$route['zone_rate/(:any)'] = 'Home'; 
$route['weight_range/(:any)'] = 'Home';  

//Couriers Management
$route['add_couriers'] = 'Home';
$route['show_couriers'] = 'Home';
$route['odometer_details'] = 'Home';
$route['edit_couriers/(:any)'] = 'Home';
$route['drivers_details/(:any)'] = 'Home';
$route['edit_odo/(:any)'] = 'Home';
$route['odo_details/(:any)'] = 'Home';
$route['assign_route/(:any)'] = 'Home';

//Branch Management
$route['add_branch'] = 'Home';
$route['show_branch'] = 'Home';
$route['edit_branch/(:any)'] = 'Home';
//Reports
$route['supplier_report'] = 'Home';
$route['shipment_report'] = 'Home';
$route['transaction_report'] = 'Home';
$route['payment_report'] = 'Home';
$route['client_report'] = 'Home';
$route['hold_report'] = 'Home';
$route['edit_status/(:any)'] = 'Home';
$route['edit_shipment/(:any)'] = 'Home';
//RTO Management
$route['rto_list'] = 'Home';
$route['rto_detail/(:any)'] = 'Home';
$route['pending_list'] = 'Home';
$route['update_rto/(:any)'] = 'Home'; 
//COD Management
$route['confirm_shipment'] = 'Home';
$route['pending_shipment'] = 'Home';
$route['totalCOD/(:any)/(:any)'] = 'Home';   
$route['codforPrint/(:any)/(:any)'] = 'CodManagement/printCOD';    
$route['codforPendingPrint/(:any)/(:any)'] = 'CodManagement/printPendingCOD';   
//Location Management
$route['add_city'] = 'Home';
$route['location_list'] = 'Home';
$route['import_hub'] = 'Home'; 
$route['add_state'] = 'Home';
$route['add_country'] = 'Home';
$route['edit_country/(:any)'] = 'Home';
$route['country_detail/(:any)'] = 'Home'; 
$route['edit_city/(:any)'] = 'Home';

 //Services Management
$route['add_services'] = 'Home';
$route['view_services'] = 'Home';
$route['edit_services/(:any)'] = 'Home';

//OFD Reports
$route['ofd_report'] = 'Home';
$route['totalofd/(:any)/(:any)/(:any)/(:any)'] = 'Home'; 
$route['todayofd/(:any)/(:any)/(:any)'] = 'Home';      
$route['totalofddetails/(:any)/(:any)/(:any)'] = 'Home';     
//Payment Details
$route['payment_details'] = 'Home';

// Invoice Management
$route['invoice_management'] = 'Home';
$route['cod_report'] = 'Home';
// product Type
$route['add_product_type'] = 'Home';
$route['show_product_type'] = 'Home';
$route['edit_product_type/(:any)'] = 'Home';
//Content Services
$route['content_services'] = 'Home';
$route['edit_content_services/(:any)'] = 'Home';
// CMS Pages
$route['cms_pages'] = 'Home';
$route['edit_cms/(:any)'] = 'Home';

// Tickets
$route['tickets'] = 'Home';
$route['ticket_reply/(:any)'] = 'Home';
// New Feedback
$route['newfeedback'] = 'Home';
// Show Rating
$route['showrating'] = 'Home';

//News
$route['edit_news/(:any)'] = 'Home';
$route['add_news'] = 'Home';
$route['show_news'] = 'Home';

//Notification

$route['add_notification'] = 'Home';
$route['show_notification'] = 'Home';
$route['edit_notification/(:any)'] = 'Home';

//Pickup Location
$route['show_location'] = 'Home';

//Email Setting
$route['email_setting'] = 'Home';
$route['edit_email_setting/(:any)'] = 'Home'; 

//SEO
$route['seo'] = 'Home';
$route['edit_seo/(:any)'] = 'Home'; 
//Featured Partners
$route['featured_partners'] = 'Home';

//Product Category List
$route['category_list'] = 'Home';

//Set User Privilege
$route['user_privilege'] = 'Home';

//Home Banner Management
$route['add_banner'] = 'Home';
$route['show_banner'] = 'Home';
$route['edit_banner/(:any)'] = 'Home';
//Outsource Management
$route['show_supplier'] = 'Home';
$route['generate_voice'] = 'Home';
$route['add_supplier'] = 'Home';
$route['edit_supplier/(:any)'] = 'Home'; 
$route['payment_supplier/(:any)'] = 'Home'; 
//AMS
$route['show_address'] = 'Home';
$route['shipment_address'] = 'Home';
$route['new_address'] = 'Home';

//Schedule Management
$route['cs_schedule'] = 'Home';
$route['blind_schedule'] = 'Home';
$route['bulk_reschedule'] = 'Home';
$route['schedule_remove'] = 'Home';
$route['date_update'] = 'Home';
$route['pending_schedule'] = 'Home';

//FAQ
$route['add_faq'] = 'Home';
$route['show_faq'] = 'Home';
$route['edit_faq/(:any)'] = 'Home';

//Zone Management
$route['zone_list'] = 'Home';
$route['city_zone'] = 'Home';
$route['country_zone'] = 'Home';
$route['cityList/(:any)'] = 'Home';
//Profile
$route['my_profile'] = 'Home';

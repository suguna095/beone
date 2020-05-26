<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class PickupManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('PickupManagement_model');
	   $this->load->helper("utility");
    }


  
   
  
	public function pickup_list()
    {
		 $_POST = json_decode(file_get_contents('php://input'), true);
	    $pickupArray=$this->PickupManagement_model->getPickupData($_POST); 
	
	
			$maniarray=$pickupArray['result'];
			foreach($maniarray as $key=>$val)
			{
					
					
					$base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($maniarray[$key]['drs_unique_id']);   
	    $maniarray[$key]['barcodeImage']=$base64; 
				
				$maniarray[$key]['city_id']=Get_name_country_by_id('city',$maniarray[$key]['city_id']);
				$maniarray[$key]['messanger_name']=get_messanger_tablefield($maniarray[$key]['messanger_id'],'messenger_name');
				$maniarray[$key]['Total_pickup']=getTotal_pickup($maniarray[$key]['drs_unique_id']);
				
				} 
          $dataArray['result']=$maniarray;  
         $dataArray['count']=$pickupArray['count']; 
		 
	echo json_encode($dataArray);
    } 
  
	public function show_pickup_detail()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $ReturnData=$this->PickupManagement_model->getPickupDetail($_POST);
		 $newReturnData=$ReturnData;
		 foreach($newReturnData as $key=>$val)
		 {
		 $newReturnData[$key]['messenger_name']=get_messanger_tablefield($val['messanger_id'],'messenger_name');
		 $newReturnData[$key]['mainstatus']=status_main_cat($val['delivered']);
		 $newReturnData[$key]['routecoude']=get_Route_code($val['slip_no']);
		 }
		 
		echo json_encode($newReturnData);
		}
		
		public function printPickupView($id=null)
		{
			$view['data1']=$this->PickupManagement_model->GetpickupPrintData($id);
			$this->load->view('printPickup',$view);
		}

} 
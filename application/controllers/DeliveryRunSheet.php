<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class DeliveryRunSheet extends CI_Controller {
 function __construct() {
        parent::__construct();
      
	  $this->load->helper('utility');
	  $this->load->model('DeliveryRunSheet_model');
    }

public function show_drs()
{
$this->load->view('deliveryrunsheet/show_drs'); 
}

public function getDrsData()
{
	 $_POST = json_decode(file_get_contents('php://input'), true);	
	
	$drsData=$this->DeliveryRunSheet_model->getDrsData($_POST);
	$returnArray=$drsData['result'];
		foreach($returnArray as $key=>$value)
	{
		$base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($returnArray[$key]['drs_unique_id']); 
			$returnArray[$key]['barcodeImage']=$base64; 
			
		$returnArray[$key]['total_shipment']=$this->DeliveryRunSheet_model->getTotal_drs_new($returnArray[$key]['drs_unique_id']);
		$returnArray[$key]['totalshipment']=$this->DeliveryRunSheet_model->getTotal_drs($returnArray[$key]['drs_unique_id']);
		$returnArray[$key]['messangerName']=get_messanger_tablefield($returnArray[$key]['messanger_id'],'messenger_name'); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
			   
		}
		 $returnArrayR['count']=$drsData['count'];
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
		
	}
   
  
  
	public function getDrsDetailData()
    { 
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 	$table_id=$_POST['drs_unique_id'];
	    	$TotalData=$this->DeliveryRunSheet_model->getDrsDetailData($table_id);
			$returnArray=$TotalData['result'];
			
		foreach($returnArray as $key=>$value)
	{
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
			   
		}
		 $returnArrayR['result']=$returnArray;
		 
		 $return['totaldrs']=$returnArray;  
		 $return['useradmin']=$this->session->userdata('useridadmin');
		 
		 
		echo json_encode($return);

    }
  
  
  	public function getnotDrsDetailData()
    { 
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 	$table_id=$_POST['drs_unique_id'];
	    	$TotalData=$this->DeliveryRunSheet_model->getnotdeliveredDetailData($table_id);
			$returnArray=$TotalData['result'];
			
		foreach($returnArray as $key=>$value)
	{
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
			   
		}
		 $returnArrayR['result']=$returnArray;
		 
		 $return['totaldrs']=$returnArray;  
		 $return['useradmin']=$this->session->userdata('useridadmin');
		 
		 
		echo json_encode($return);

    }
	
	public function getDeliveredDrsDetailData()
    { 
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 	$table_id=$_POST['drs_unique_id'];
	    	$TotalData=$this->DeliveryRunSheet_model->getdeliveredDetailData($table_id);
			$returnArray=$TotalData['result'];
			
		foreach($returnArray as $key=>$value)
	{
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
			   
		}
		 $returnArrayR['result']=$returnArray;
		 
		 $return['totaldrs']=$returnArray;  
		 $return['useradmin']=$this->session->userdata('useridadmin');
		 
		 
		echo json_encode($return);

    }
	
	
 	public function delete_drs()
	{
		$CURRENT_DATE=date("Y-m-d H:i:s");
		$CURRENT_TIME=date("H:i:s");

		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		$useradmin=$this->session->userdata('useridadmin');
		  $DRSData=$this->DeliveryRunSheet_model->getdeleteDrsDetail($_POST);  
		  $CodeData=$this->DeliveryRunSheet_model->getActivity();
		  $adminDetailsData=$this->DeliveryRunSheet_model->getadminDetails($useradmin);
		  
		  
		 $ReturnData=$this->DeliveryRunSheet_model->getdrsdelete($array,$_POST['id']);   

		$statusArray=array('slip_no'=>$DRSData['shipment_id'],'new_location'=>$adminDetailsData['branch_location'],'new_status'=>'2','pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>$CodeData['sub_status'],'Details'=>$CodeData['sub_status'],'entry_date'=>$CURRENT_DATE,'code'=>'RDRS','user_id'=>$useradmin,'user_type'=>'user');	
		$res_data=$this->DeliveryRunSheet_model->insertStatus($statusArray);
		
		//print_r($statusArray); die();
		 echo json_encode($res_data);  
	}
	
	public function getshowdrs()
    {
	    $retuenArray=$this->DeliveryRunSheet_model->getDrsDetail();
		echo json_encode($retuenArray);
    }
	
	
	public function update_drs()
	{
		$CURRENT_DATE=date("Y-m-d H:i:s");
		$CURRENT_TIME=date("H:i:s");

		$_POST = json_decode(file_get_contents('php://input'), true);
		$DRSarray=array('delivered'=>'N','delivery_status'=>'N'); 
		
		$useradmin=$this->session->userdata('useridadmin');
		$DRSData=$this->DeliveryRunSheet_model->getdeleteDrsDetail($_POST);
		$adminDetailsData=$this->DeliveryRunSheet_model->getadminDetails($useradmin);
	
		$ReturnData=$this->DeliveryRunSheet_model->getdrsdelete($DRSarray,$_POST['id']);
		
	$Shipmentarray=array('delivered'=>'5','code'=>'OD'); 
		
		  
		
		
		$ReturnData=$this->DeliveryRunSheet_model->getshipmentdelete($Shipmentarray,$DRSData['shipment_id']);
		
		//print_r($Shipmentarray); die();

		$user=$adminDetailsData['name'];   
		$details='Shipment Status Changed by."".$user';  
		
		$statusArray=array('slip_no'=>$DRSData['shipment_id'],'new_location'=>$adminDetailsData['branch_location'],'new_status'=>'5','pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>'Shipment Status Changed','Details'=>$details,'entry_date'=>$CURRENT_DATE,'code'=>'MU','user_id'=>$useradmin,'user_type'=>'user');	
		$res_data=$this->DeliveryRunSheet_model->insertStatus($statusArray);
		
		//print_r($statusArray); die();
		 echo json_encode($DRSData);  
	}
	
		public function print_fordel($drs_unique_id)
	{
		
		    $citydata=$this->DeliveryRunSheet_model->GetalldrsPritqry($drs_unique_id);
			$total=count($citydata);
			if(!empty($citydata))
			{
				$ammountdue=0;
				foreach($citydata as $key=>$val)
				{
					if($citydata[$key]['client_type']=='B2C')
					$ammountdue=$ammountdue+$citydata[$key]['total_cod_amt'];
					else
					$ammountdue=$ammountdue+($citydata[$key]['total_cod_amt'] +$citydata[$key]['cod_fees'] +$citydata[$key]['service_charge'] );
				}
			}
			$view['ammountdue']=$ammountdue;
			$view['data1']=$citydata;
			$view['total']=$total;
			
			$this->load->view('printdrsyshow',$view);
		
	}
	
	
	
	
}
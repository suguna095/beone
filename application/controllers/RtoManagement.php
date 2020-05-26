<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class RtoManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->helper('utility'); 
	   $this->load->model('RtoManagement_model');
    }


 public function GetshowRto()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $RtoDetailArray=$this->RtoManagement_model->Showrto($_POST); 
		$returnArray=$RtoDetailArray['result'];
		foreach($returnArray as $key=>$val)
		{
			
			$base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($returnArray[$key]['drs_unique_id']); 
			$returnArray[$key]['barcodeImage']=$base64; 
		    $returnArray[$key]['total_shipment']=$this->RtoManagement_model->getTotal_drs_new($returnArray[$key]['drs_unique_id']);
		    $returnArray[$key]['totalshipment']=$this->RtoManagement_model->getTotal_drs($returnArray[$key]['drs_unique_id']);
		    $returnArray[$key]['messangerName']=get_messanger_tablefield($returnArray[$key]['messanger_id'],'messenger_name');	
		    $returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');	
			$returnArray[$key]['routecode']=getRoutCode($returnArray[$key]['routecode']);	
			 $returnArray[$key]['supplier']=getsupplierbyid($returnArray[$key]['messanger_id']);   	
			
			
			  $returnArray[$key]['getProcessed']=getProcessed_drs($returnArray[$key]['drs_unique_id']);
			  $returnArray[$key]['getTotal']=getTotal_return($returnArray[$key]['drs_unique_id']);
		}
		$returnArrayR['postdata']=$_POST;
        $returnArrayR['count']=$RtoDetailArray['count'];
		 $returnArrayR['result']=$returnArray;
		echo json_encode($returnArrayR); 
    }
	
	public function GetshowPendingRto()  
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->RtoManagement_model->ShowPending($_POST['searchpending'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		$dataArray['adata']=$_POST ;   
		foreach($maniarray as $key=>$val)
		{
		$maniarray[$key]['supplier']=getsupplierbyid($maniarray[$key]['messanger_id']);	 
		$maniarray[$key]['city']=getcitybyid($maniarray[$key]['city']); 
			
		}         
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count']; 
		echo json_encode($dataArray); 
    }
	       
	public function RtoCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->RtoManagement_model->GetCityRtoDrop();     
		echo json_encode($returnArray);
	}
	
	public function getRtoDetailData()
    { 
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 	$table_id=$_POST['drs_unique_id'];
	    	$TotalData=$this->RtoManagement_model->getRtoDataDetail($table_id);
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
	

	public function getUpdateRtoDetailData()
    { 
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 	$table_id=$_POST['drs_unique_id'];
	    	$TotalData=$this->RtoManagement_model->getUpdateRtoDataDetail($table_id);
			$returnArray=$TotalData['result'];
			
		foreach($returnArray as $key=>$value)
	{
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
		$returnArray[$key]['show_code']=getActivity($returnArray[$key]['code']);
			   
		}
		 $returnArrayR['result']=$returnArray;
		 
		 $return['totaldrs']=$returnArray;  
		 $return['useradmin']=$this->session->userdata('useridadmin');
		 
		 
		echo json_encode($return);

    }
	

	public function GetupdatemanifestChekData()
	{   
		$_POST = json_decode(file_get_contents('php://input'), true);
		$shipmentIDS=$_POST;     
		
		      
				$entrydate=date('Y-m-d H:i:s');
				$CURRENT_DATE=date("Y-m-d H:i:s");
				$CURRENT_TIME=date("H:i");
				$city=$this->session->userdata('adminbranchlocation');
				$userityname=Get_name_country_by_id('city',$city);    
				$update_details="RTO By ".$this->session->userdata('user_name')." at $userityname";      

				foreach($shipmentIDS as $shipID)
				{
					
					$check_value=$shipID; 
					
					if($check_value!='')
					{
					$update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,code) values ('".$check_value."','".$city."','13','".$CURRENT_TIME."','".$CURRENT_DATE."','Return to Warehouse','".$update_details."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','RI')";
					      
				$this->RtoManagement_model->AddrtoStatusdata($update_status);


				$code='RI';
				$booking_id=getBookingId($check_value);
				$details=$update_details;

				//ApiaddGetsliperRefNoStatusUpdate($booking_id,$code,$details,getCityCode($this->session->userdata('adminbranchlocation')));	  
				$drsdata=$this->RtoManagement_model->getDRSUniqueid($check_value);


				$drs_update_query="update drs set rto_status='Y',delivered='Y',rto_datetime='$entrydate' where drs_unique_id='".$drsdata['drs_unique_id']."' and shipment_id='".$check_value."'";      
				$this->RtoManagement_model->AddrtoStatusdata($drs_update_query);

					 $update_shipment_query="update shipment set delivered='13',code='RI' where slip_no='".$check_value."'"; 

						$this->RtoManagement_model->AddrtoStatusdata($update_shipment_query);
					 $return= true;
					}else{
						$return= false;
					 }		
					}
		
			echo json_encode($return);       
	}



	
	public function update_Rto()
	{
		$CURRENT_DATE=date("Y-m-d H:i:s");
		$CURRENT_TIME=date("H:i:s");

		$_POST = json_decode(file_get_contents('php://input'), true);
		$DRSarray=array('delivered'=>'N','delivery_status'=>'N'); 
		
		$useradmin=$this->session->userdata('useridadmin');
		$DRSData=$this->RtoManagement_model->getdeleteDrsDetail($_POST);
		$adminDetailsData=$this->RtoManagement_model->getadminDetails($useradmin);
	
		$ReturnData=$this->RtoManagement_model->getdrsdelete($DRSarray,$_POST['id']);
		
	$Shipmentarray=array('delivered'=>'5','code'=>'OD'); 
		
		  
		
		
		$ReturnData=$this->RtoManagement_model->getshipmentdelete($Shipmentarray,$DRSData['shipment_id']);
		
		//print_r($Shipmentarray); die();

		$user=$adminDetailsData['name'];   
		$details='Shipment Status Changed by."".$user';  
		
		$statusArray=array('slip_no'=>$DRSData['shipment_id'],'new_location'=>$adminDetailsData['branch_location'],'new_status'=>'5','pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>'Shipment Status Changed','Details'=>$details,'entry_date'=>$CURRENT_DATE,'code'=>'MU','user_id'=>$useradmin,'user_type'=>'user');	
		$res_data=$this->RtoManagement_model->insertStatus($statusArray);
		
		//print_r($statusArray); die();
		 echo json_encode($DRSData);  
	}
  
  
  public function delete_Rto() 
	{
		$CURRENT_DATE=date("Y-m-d H:i:s");
		$CURRENT_TIME=date("H:i:s");

		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		$useradmin=$this->session->userdata('useridadmin');
		  $DRSData=$this->RtoManagement_model->getdeleteDrsDetail($_POST);  
		  $CodeData=$this->RtoManagement_model->getActivity();
		  $adminDetailsData=$this->RtoManagement_model->getadminDetails($useradmin);
		  
		  
		 $ReturnData=$this->RtoManagement_model->getdrsdelete($array,$_POST['id']);   

		$statusArray=array('slip_no'=>$DRSData['shipment_id'],'new_location'=>$adminDetailsData['branch_location'],'new_status'=>'2','pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>$CodeData['sub_status'],'Details'=>$CodeData['sub_status'],'entry_date'=>$CURRENT_DATE,'code'=>'RDRS','user_id'=>$useradmin,'user_type'=>'user');	
		$res_data=$this->RtoManagement_model->insertStatus($statusArray);
		
		//print_r($statusArray); die();
		 echo json_encode($res_data);  
	}
	
	public function print_rtol($drs_unique_id)
	{
		
		    $citydata=$this->RtoManagement_model->GetalldrsPritqry($drs_unique_id);
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
			//print_r($ammountdue); exit;  
			//echo "hiii"; exit;
			$this->load->view('printrtoyshow',$view); 
		
	}
}
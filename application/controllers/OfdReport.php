<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class OfdReport extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->helper('utility');
	  $this->load->model('OfdReport_model');
    }
public function ofd_report()
{ 
$this->load->view('ofdreport/ofd_report');
}
public function getOfdData()
{
	 $_POST = json_decode(file_get_contents('php://input'), true);
	$this->load->helper('utility'); 
	
	
	$shipmentData=$this->DeliveryRunSheet_model->getOfdData($_POST);
	
	
	
	//"id":"240083","drs_unique_id":"PCC4DU","routecode":"RUH-110","messanger_id":"138","shipment_id":"TAM1872304491","city_id":"","drs_date":"2019-11-20","drs_bar_image":"","drs_bar_code":"","sign_image":"","delivey_complete_date":"0000-00-00 00:00:00","delivered":"N","delivery_status":"N","attempt":"0","rto_status":"N","rto_datetime":"2019-11-20 08:05:25","amount_received":"N","deleted":"N"
	$returnArray=$shipmentData['result'];
	foreach($returnArray as $key=>$value)
	{
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
		
	   
		$base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($returnArray[$key]['drs_unique_id']); 
				
				    
		$returnArray[$key]['barcodeImage']=$base64; 
		 
		
		}
		 $returnArrayR['count']=$shipmentData['count'];
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
	} 
   
  
 
	public function allofdreportlist1()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $ofdAray=$this->OfdReport_model->alllistData1($_POST);
		 
		$returnArray=$ofdAray['result'];
		$totalstatusShow=0;
		$totalRunningShow=0;
		$totaldeliveredShow=0;
		$totaldelivery_statusShow=0;
	foreach($returnArray as $key=>$value)
		{
		
		
		$totalstatus=$this->OfdReport_model->GetCheckDrsStatusQry_dash($value['drs_unique_id'],'',$value['messanger_id']);
		$totalRunning=$this->OfdReport_model->GetCheckDrsStatusQry_dash($value['drs_unique_id'],'running',$value['messanger_id']);
		$totaldelivered=$this->OfdReport_model->GetCheckDrsStatusQry_dash($value['drs_unique_id'],'delivered',$value['messanger_id']);
		$totaldelivery_status=$this->OfdReport_model->GetCheckDrsStatusQry_dash($value['drs_unique_id'],'delivery_status',$value['messanger_id']);	
		
		$totalstatusShow+=$totalstatus;
		$totalRunningShow+=$totalRunning;
		$totaldeliveredShow+=$totaldelivered;
		$totaldelivery_statusShow+=$totaldelivery_status;
		
		
		
		$returnArray[$key]['totaldrs']=$totalstatus;
		$returnArray[$key]['delivered']=$totaldelivery_status;
		$returnArray[$key]['running']=$totalRunning;
		$returnArray[$key]['notdeliverd']=$totaldelivered;
		$returnArray[$key]['totalRunning']=$totalRunning;	
		$returnArray[$key]['totalstatus']=$totalstatus;	
		$returnArray[$key]['totaldelivered']=$totaldelivered;	
		$returnArray[$key]['totaldelivery_status']=$totaldelivery_status;	
		$returnArray[$key]['totalperformance']=floor($returnArray[$key]['delivered']/$returnArray[$key]['totaldrs']*100);
		
		
		$returnArray[$key]['supplierName']=getsupplierbyid($returnArray[$key]['supplier']);  
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
		}
		$returnArrayR['totalcompletedrs']=$totalstatusShow;
		$returnArrayR['totaldelivered']=$totaldelivery_statusShow;
		$returnArrayR['totalrunning']=$totalRunningShow;
		$returnArrayR['totalnotdeliverd']=$totaldeliveredShow;
		
		 $returnArrayR['totalinfo']=$returnArray;
	echo json_encode($returnArrayR);
		
		 
	}
	
	public function allofdreportlist()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $ofdAray=$this->OfdReport_model->alllistData($_POST);
		 
		$returnArray=$ofdAray['result'];
		$totalstatusShow=0;
		$totalRunningShow=0;
		$totaldeliveredShow=0;
		$totaldelivery_statusShow=0;
	foreach($returnArray as $key=>$value)
		{
		
		$totalstatus=$this->OfdReport_model->GetCheckDrsStatusQry($value['drs_unique_id'],'',$_POST,$value['messanger_id']);
		$totalRunning=$this->OfdReport_model->GetCheckDrsStatusQry($value['drs_unique_id'],'running',$_POST,$value['messanger_id']);
		$totaldelivered=$this->OfdReport_model->GetCheckDrsStatusQry($value['drs_unique_id'],'delivered',$_POST,$value['messanger_id']);
		$totaldelivery_status=$this->OfdReport_model->GetCheckDrsStatusQry($value['drs_unique_id'],'delivery_status',$_POST,$value['messanger_id']);	
		
		$totalstatusShow+=$totalstatus;
		$totalRunningShow+=$totalRunning;
		$totaldeliveredShow+=$totaldelivered;
		$totaldelivery_statusShow+=$totaldelivery_status;
		
		
		
		$returnArray[$key]['totaldrs']=$totalstatus;
		$returnArray[$key]['delivered']=$totaldelivery_status;
		$returnArray[$key]['running']=$totalRunning;
		$returnArray[$key]['notdeliverd']=$totaldelivered;
		$returnArray[$key]['totalRunning']=$totalRunning;	
		$returnArray[$key]['totalstatus']=$totalstatus;	
		$returnArray[$key]['totaldelivered']=$totaldelivered;	
		$returnArray[$key]['totaldelivery_status']=$totaldelivery_status;	
		$returnArray[$key]['totalperformance']=floor($returnArray[$key]['delivered']/$returnArray[$key]['totaldrs']*100);
		
		
		
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']);
		$returnArray[$key]['supplierName']=getsupplierbyid($returnArray[$key]['supplier']);  
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
		}
		$returnArrayR['totalcompletedrs']=$totalstatusShow;
		$returnArrayR['totaldelivered']=$totaldelivery_statusShow;
		$returnArrayR['totalrunning']=$totalRunningShow;
		$returnArrayR['totalnotdeliverd']=$totaldeliveredShow;
		if(!empty($_POST['start_date']))
		$returnArrayR['start_date']=$_POST['start_date'];
		else
		$returnArrayR['start_date']=date("d-m-Y");
		if(!empty($_POST['end_date']))
		$returnArrayR['end_date']=$_POST['end_date'];
		else
		$returnArrayR['end_date']=date("d-m-Y");
		
		 $returnArrayR['totalinfo']=$returnArray;
	echo json_encode($returnArrayR);
		
		 
	}
	   
	  	public function getSupplierDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->OfdReport_model->getSupplierDropData();      
		echo json_encode($returnArray);
	}
  
	    	public function ShowtotalofdDetails()
	{
		$_POST = json_decode(file_get_contents('php://input'), true); 
		$totalofdAray=$this->OfdReport_model->gettotalofsData($_POST);      
		$returnArray=$totalofdAray['result'];
	   foreach($returnArray as $key=>$value) 
		{
	
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
		$returnArray[$key]['Details']=get_comment($returnArray[$key]['slip_no'],'1');    
		//$returnArray[$key]['drivercomment']=get_detail($returnArray[$key]['slip_no'],'1');		
		$returnArray[$key]['citydata']=status_main_cat('1');
		}
	
		
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
	}
	  
	

	public function ShowtodayofdDetails()
	{
		$_POST = json_decode(file_get_contents('php://input'), true); 
		$totalofdAray=$this->OfdReport_model->gettotalofsData($_POST);      
		$returnArray=$totalofdAray['result'];
	foreach($returnArray as $key=>$value) 
		{
	
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['origin']=getdestinationfieldshow($returnArray[$key]['origin'],'city');
		$returnArray[$key]['destination']=getdestinationfieldshow($returnArray[$key]['destination'],'city');
		$returnArray[$key]['Details']=get_comment($returnArray[$key]['slip_no'],'1');    
		//$returnArray[$key]['drivercomment']=get_detail($returnArray[$key]['slip_no'],'1');	
		$returnArray[$key]['entrydate']=date("D d M Y",strtotime($returnArray[$key]['entrydate']));	
		$returnArray[$key]['citydata']=status_main_cat('1');
		}
	
		
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
	}


	    	public function Showtotalofdlist()
	{
		$_POST = json_decode(file_get_contents('php://input'), true); 
		$totalofdAray=$this->OfdReport_model->gettotalofdlistData($_POST);      
		$returnArray=$totalofdAray['result'];
	foreach($returnArray as $key=>$value) 
		{
	
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
			$returnArray[$key]['Details']=get_comment($returnArray[$key]['slip_no'],'1');
		//$returnArray[$key]['drivercomment']=get_detail($returnArray[$key]['slip_no'],'1');		
		$returnArray[$key]['citydata']=status_main_cat('1');
		}
	
		
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
	}
}
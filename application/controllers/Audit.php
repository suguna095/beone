<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Audit extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
       $this->load->model("Audit_model");
    }


   public function view_reason_Excel()
    {
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->Audit_model->getviewreasonExcel($_POST); 
		
		echo json_encode($returnArray);
    }
	
	public function view_reason()
    {
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->Audit_model->getviewreason($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		$dataArray['pdata']=$_POST ;
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }
	
public function add_reason()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_reason']; 
		 $date=date("Y-m-d H:i:s");
		 $reasonArray=array('audit_type'=>$dataArray['audit_type'],'comment'=>$dataArray['comment'],'audit_status'=>$dataArray['audit_status'],'date'=>$date);
		 
         $res_data=$this->Audit_model->InsertReason($reasonArray);
		 
		 echo json_encode($res_data);
	 }
     
	 public function get_delete_reason()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('delete_status'=>'Y');
		 $ReturnData=$this->Audit_model->getreasondelete($array,$_POST['id']);  
		 echo json_encode($ReturnData);  
	}
	
	public function geteditreasonData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['reid'];
		
		$returnArray=$this->Audit_model->Getreasonlist_edit($table_id);
	
		 echo json_encode($returnArray);
	}
	
	 public function edit_reasonform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_reason'];
		 $reid = $dataArray['reid']; 
         $editreasonArray=array('audit_type'=>$dataArray['audit_type'],'comment'=>$dataArray['comment'],'audit_status'=>$dataArray['audit_status']);
         $res_data=$this->Audit_model->ReasonUpdate($editreasonArray,$reid); 	
          echo json_encode($res_data);	  	 
	 } 
	 
	  public function view_audit() 
    {
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->Audit_model->getviewaudit($_POST,$_POST['page_no']); 
		$maniarray1=$returnArray['result'];
		
		foreach($maniarray1 as $key=>$value)
		{
		
		$maniarray1[$key]['driverName']=getDriverNameByid($maniarray1[$key]['driver_id']); 
		$maniarray1[$key]['origin']=getdestinationfieldshow($maniarray1[$key]['origin'],'city');
		$maniarray1[$key]['destination']=getdestinationfieldshow($maniarray1[$key]['destination'],'city');
		$maniarray1[$key]['auditor_name']=Get_user_name($maniarray1[$key]['auditor_id'],'user');
		}
		
		$dataArray['total_pending']=$this->Audit_model->viewaudit_total_pending($_POST);  
		$dataArray['total_complete']=$this->Audit_model->viewaudit_total_complete($_POST);  	
			
		$dataArray['result']=$maniarray1;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray); 
   
	
    }
	
	 public function view_CSaudit()  
    {
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->Audit_model->getviewCSaudit($_POST,$_POST['page_no']);  
		$maniarray1=$returnArray['result'];
		
		foreach($maniarray1 as $key=>$value)
		{
		
		$maniarray1[$key]['driverName']=getDriverNameByid($maniarray1[$key]['driver_id']); 
		$maniarray1[$key]['origin']=getdestinationfieldshow($maniarray1[$key]['origin'],'city');
		$maniarray1[$key]['destination']=getdestinationfieldshow($maniarray1[$key]['destination'],'city');
		}
		
		$dataArray['total_pending']=$this->Audit_model->cs_total_pending($_POST);  
		$dataArray['total_complete']=$this->Audit_model->cs_total_complete($_POST);  	
			
		$dataArray['result']=$maniarray1;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray); 
    }
	
	
	 public function view_Operationaudit()  
    {
	    $_POST = json_decode(file_get_contents('php://input'), true);
		//$cityList=$this->Audit_model->totalCityList($_POST['hub']);
		
		
	    $returnArray=$this->Audit_model->getviewOPaudit($_POST,$_POST['page_no']);  
		$maniarray1=$returnArray['result'];
		
		
		foreach($maniarray1 as $key=>$value)
		{
		
		$maniarray1[$key]['driverName']=getDriverNameByid($maniarray1[$key]['driver_id']); 
		$maniarray1[$key]['origin']=getdestinationfieldshow($maniarray1[$key]['origin'],'city');
		$maniarray1[$key]['destination']=getdestinationfieldshow($maniarray1[$key]['destination'],'city');
		}
		
		$dataArray['total_pending']=$this->Audit_model->total_pending($_POST);  
		$dataArray['total_complete']=$this->Audit_model->total_complete($_POST);  	
			
		$dataArray['result']=$maniarray1;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray); 
    }
	
	public function getStatusDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->Audit_model->showstatusDrop($_POST);     
		echo json_encode($returnArray);
	}
	
	public function getReasonsDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->Audit_model->showstatusDrop($_POST);     
		echo json_encode($returnArray);
	}
	
	 public function getStatusListDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->Audit_model->showstatusListDrop();     
		echo json_encode($returnArray);
	} 
	
	public function getAuditData()
{
	$_POST = json_decode(file_get_contents('php://input'), true);
	$table_id=$_POST['id'];
	$returnArray=$this->Audit_model->showAuditData($table_id);
	echo json_encode($returnArray);
}


	public function UpdateStatus()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$CURRENT_DATE=date("Y-m-d H:i:s");
		$CURRENT_TIME=date("H:i:s");
		$useradmin=$this->session->userdata('useridadmin');
		
		$AuditArray=$_POST['modaldata'];
		$id=$AuditArray['id'];
		$CityCodeData=$this->Audit_model->getCityCodeDetail($AuditArray['destination']);
		$StatusData=$this->Audit_model->getSubStatusDetail($AuditArray['shipment_status']);
		$adminDetailsData=$this->Audit_model->getadminDetails($useradmin);
		
		$DRSarray=array('audit_comment'=>$AuditArray['audit_comment'],'audit_status'=>'N','audit_date'=>$CURRENT_DATE,'auditor_id'=>$useradmin,'id'=>$id); 
		
			//print_r($DRSarray); die();
			
	$statusArray=array('slip_no'=>$AuditArray['slip_no'],'new_location'=>$adminDetailsData['branch_location'],'city_code'=>$CityCodeData['city_code'],'pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>'Audit','Details'=>$StatusData['sub_status'],'comment'=>$AuditArray['audit_comment'],'entry_date'=>$CURRENT_DATE,'user_id'=>$useradmin,'user_type'=>'user','code'=>$AuditArray['shipment_status']); 
		
		//print_r($statusArray); die();
		
		$adminDetailsData=$this->Audit_model->updateStatusDetails($DRSarray,$id);
		
		$StatusDetailsData=$this->Audit_model->insertStatus($statusArray);
	

		
	
		 echo json_encode($StatusDetailsData);  
	}
  
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ServicesManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model("ServicesManagement_model");
    }
   public function ViewServicelist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->ServicesManagement_model->GetServicelistData(); 
		
		echo json_encode($returnArray); 
    }
	
	public function get_delete_services()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		 $ReturnData=$this->ServicesManagement_model->getserviceedelete($array,$_POST['id']);  
		 echo json_encode($ReturnData);  
	}
	
	 public function AddServices()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_service']; 
		 
		 $services_name=$dataArray['services_name'];
		
		$returnArray=$this->ServicesManagement_model->GetServiceDetails($services_name);
		if($returnArray==0){
		 $serviceArray=array('services_name'=>$dataArray['services_name']);
		  
         $res_data=$this->ServicesManagement_model->InsertService($serviceArray);
		 
		 $return= true; 
		}else{
			 $res_data=false;
			$return= false; 
		}
		
        echo json_encode($return);
	 }
	 
	 public function GetServicetatusUpdate()
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
        $array=array('status'=>$_POST['status']);  
		
		 $returnArray=$this->ServicesManagement_model->UpdateserviceStatus($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	   
	 public function ShowEditService()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['id'];
		
		$returnArray=$this->ServicesManagement_model->GetEditData($table_id);
	
		 echo json_encode($returnArray);
	}
	
	 public function UpdateService()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_service'];
		 $id = $dataArray['id']; 
         $serviceeditArray=array('services_name'=>$dataArray['services_name']);
         $res_data=$this->ServicesManagement_model->ServiceUpdateData($serviceeditArray,$id); 	
          echo json_encode($res_data);	  	 
	 } 
	 
	
}
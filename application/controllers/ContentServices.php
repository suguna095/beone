<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ContentServices extends CI_Controller {
 function __construct() {
        parent::__construct();
		  $this->load->helper('utility');
	  $this->load->model('ContentServices_model');
       error_reporting(0);
    }

public function getContentData()
{
	 $_POST = json_decode(file_get_contents('php://input'), true);
	$returnArray=$this->ContentServices_model->getContentservicesData($_POST); 
	$returnArrayR=$returnArray['result'];
	$dataArray['result']=$returnArrayR;
	$dataArray['count']=$returnArray['count'];  
     
	echo json_encode($returnArray);
	}
   
  
  public function AddContent()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['add_services'];
		$serveArray=array('services_name'=>$dataArray['services_name']);
	    $res_data=$this->ContentServices_model->insertContent($serveArray);  
	    $return= true;  
        echo json_encode($return);
	}

   public function get_delete_content()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		 $ReturnData=$this->ContentServices_model->getcontentdelete($array,$_POST['id']);   
		 echo json_encode($ReturnData);  
	}

  public function ShowEditcontent() 
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['conid'];
		
		$returnArray=$this->ContentServices_model->Getservices_edit($table_id);
	
		 echo json_encode($returnArray);
	}

  public function EditContent()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['edit_services'];
		$conid = $dataArray['conid'];
		$editserveArray=array('services_name'=>$dataArray['services_name']);
	    $res_data=$this->ContentServices_model->ConServiceUpdate($editserveArray,$conid );  
	    $return= true;  
        echo json_encode($return);
	}
	
		public function GetstaffstatusUpdate()
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
        $array=array('status'=>$_POST['status']);  
		
		 $returnArray=$this->ContentServices_model->ConServiceUpdate($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
}
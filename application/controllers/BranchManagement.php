<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class BranchManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('BranchManagement_model');
	   $this->load->helpers('utility_helper');
    }
    
	public function showBranchlist()
    {
		 $_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->BranchManagement_model->getShowBranch(); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
		
		$maniarray[$key]['city']=getcitybyid($maniarray[$key]['city'],'city'); 		
			
		}
       $dataArray['result']=$maniarray;   
         $dataArray['count']=$returnArray['count'];
		 echo json_encode($dataArray);
    }
	
	
	
	public function get_delete_branch()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		 $ReturnData=$this->BranchManagement_model->getbranchdelete($array,$_POST['id']);  
		 echo json_encode($ReturnData);  
	}
	
	public function add_branch()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_branch']; 
		 
		 $branchArray=array('branch_city'=>$dataArray['branch_city'],'branch_peson'=>$dataArray['branch_person'],'branch_address'=>$dataArray['branch_address'],
		'branch_contact'=>$dataArray['branch_contact']);
		
         $ReturnData=$this->BranchManagement_model->updateBranch($branchArray);     
		 
		 echo json_encode($ReturnData);  
		 
		 
	 }
	 
	  public function geteditbranchData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['branchid'];
		
		$returnArray=$this->BranchManagement_model->Getbranchlist_edit($table_id);
	
		 echo json_encode($returnArray);
	}
	
	public function edit_branchform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_branch']; 
		 $branchid = $dataArray['id']; 
         $editbranchArray=array('branch_city'=>$dataArray['branch_city'],'branch_peson'=>$dataArray['branch_peson'],'branch_address'=>$dataArray['branch_address'],
		 'branch_contact'=>$dataArray['branch_contact']);
         $res_data=$this->BranchManagement_model->branchFetch($editbranchArray,$branchid); 	
         echo json_encode($res_data);	  	 
	 } 
	 public function GetstaffstatusUpdate()
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
        $array=array('status'=>$_POST['status']);  
		
		 $returnArray=$this->BranchManagement_model->Getupdateactivestatus($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
	public function BranchCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->BranchManagement_model->GetCityBranchDrop();     
		echo json_encode($returnArray);
	}
	
}
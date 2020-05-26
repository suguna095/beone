<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class SetUserPrivilege extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model('SetUserPrivilege_model'); 
	   $this->load->helper("utility");
    }
	public function user_privilege()
	{
	$this->load->view('setuserprivilege/user_privilege');
	} 
	public function getUserprivilegeData() 
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->SetUserPrivilege_model->getUserprivilegeData($_POST);   
		$newreturnArray=$returnArray;
		$kk=0;
		foreach($newreturnArray as $rdata)
		{
		$newreturnArray[$kk]['CheckAccess']=checkPrivilageExitsForCustomer($_POST['user_id'],$rdata['id']);
		$kk++;
		}
		echo json_encode($newreturnArray);
		}
	
	
	public function GetallUserlistData()
	{
		   $returnArray=$this->SetUserPrivilege_model->GetalluserQry();  
			echo json_encode($returnArray); 
	}
	public function setCustomerPrivilage()
	{
		
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $postArray=$_POST;
		$customer_id=$postArray['user_id'];
		$privilage_id=$postArray['id'];
		$onoff_true_false=$postArray['onoff_true_false'];
		$data=array('customer_id'=>$customer_id,'privilage_id'=>$privilage_id,'onoff_true_false'=>$onoff_true_false);
		$result=$this->SetUserPrivilege_model->setCustomerPrivilageUpdate($data);
		
		
		echo json_encode($result); 
		
		
		
	}
	
}	
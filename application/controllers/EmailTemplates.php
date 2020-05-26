<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class EmailTemplates extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model("EmailTemplates_model");
    }
   
   public function showemailData()
  {
	  $_POST = json_decode(file_get_contents('php://input'), true);
	   $return_array=$this->EmailTemplates_model->getmails();
	   
	   echo json_encode($return_array);
  }
  
  public function getEditEmailData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['mailid'];
		
		$returnArray=$this->EmailTemplates_model->Getmaillist_edit($table_id);
	
		 echo json_encode($returnArray);
	}
	
	public function edit_mailform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_mails'];
		 $mailid = $dataArray['id']; 
         $editmailArray=array('subject'=>$dataArray['subject'],'msg'=>$dataArray['msg']);
         $res_data=$this->EmailTemplates_model->mailUpdate($editmailArray,$mailid); 	
          echo json_encode($res_data);	  	 
	 } 
}
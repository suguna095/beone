<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Faq extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model("Faq_model");
    }
    public function showfaqData()
  {
	  $_POST = json_decode(file_get_contents('php://input'), true);
	   $return_array=$this->Faq_model->getfaq();
       echo json_encode($return_array);
  }
  
  public function get_delete_faq()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('status'=>'1');
		 $ReturnData=$this->Faq_model->getfaqdelete($array,$_POST['id']);  
		 echo json_encode($ReturnData);  
	}
	public function add_faq()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_faq']; 
		 
		 $faqArray=array('question'=>$dataArray['question'],'answer'=>$dataArray['answer']);
		 
         $res_data=$this->Faq_model->updateFaq($faqArray);
		 
		 echo json_encode($res_data);
	 }
	 
	  public function geteditfaqData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['faqid'];
		
		$returnArray=$this->Faq_model->getEditfaq($table_id);
	
		 echo json_encode($returnArray);
	}
	
	 public function edit_faqform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_faq'];
		 $faqid = $dataArray['id']; 
        $editfaqArray=array('question'=>$dataArray['question'],'answer'=>$dataArray['answer']);
         $res_data=$this->Faq_model->faqUpdate($editfaqArray,$faqid); 	
          echo json_encode($res_data);	  	 
	 } 
}

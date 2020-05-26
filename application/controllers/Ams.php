<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Ams extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   
	   $this->load->model('Ams_model');
    }
 
	  public function ShowAms() 
    {
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->Ams_model->getAMSdata(); 
		$maniarray1=$returnArray['result'];
        $dataArray['result']=$maniarray1;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($returnArray);
    }
	
	public function add_Address()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_address']; 
		 
		 $amsArray=array('name'=>$dataArray['name'],'city'=>$dataArray['city'],'mobile'=>$dataArray['mobile'],'zip_code'=>$dataArray['zip_code']
		 ,'address'=>$dataArray['address'],'email'=>$dataArray['email']);
		 
         $res_data=$this->Ams_model->InsertAms($amsArray);
		 
		 echo json_encode($res_data);
	 }
	 
	 
}
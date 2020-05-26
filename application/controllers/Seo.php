<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Seo extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model("Seo_model");
    }
public function showseoData()
  {
	  $_POST = json_decode(file_get_contents('php://input'), true);
	   $return_array=$this->Seo_model->getseo();
	   
	   echo json_encode($return_array);
  }
  
   public function getSeoData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['seoid'];
		
		$returnArray=$this->Seo_model->Getseolist_edit($table_id);
	
		 echo json_encode($returnArray);
	}
	
	public function edit_seoform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_seo'];
		 $seoid = $dataArray['id']; 
         $editseoArray=array('name'=>$dataArray['name'],'title'=>$dataArray['title'],'keyword'=>$dataArray['keyword'],'des'=>$dataArray['des']);
         $res_data=$this->Seo_model->seoUpdate($editseoArray,$seoid); 	
          echo json_encode($res_data);	  	 
	 } 
}
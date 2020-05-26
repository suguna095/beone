<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ProductType extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model('ProductType_model');
    }
  public function AddProduct()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->ProductType_model->getAddProduct($_POST['searchcod'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		$dataArray['adata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }
	
	public function get_delete_Product()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		 $ReturnData=$this->ProductType_model->getProductdelete($array,$_POST['pac_id']);  
		 echo json_encode($ReturnData);  
	}
	
	public function add_product_type()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true); 
		 $dataArray=$_POST['add_product']; 
		 $CURRENT_DATE=date("Y-m-d");
		 $productArray=array('title'=>$dataArray['title'],'dimesion_weight'=>$dataArray['dimesion_weight'],'dimesion_height'=>$dataArray['dimesion_height'],'dimesion_width'=>$dataArray['dimesion_width']
		 ,'dimesion_girth'=>$dataArray['dimesion_girth'],'pickupcharge'=>$dataArray['pickupcharge'],'from_time'=>$dataArray['from_time']
		 ,'to_time'=>$dataArray['to_time'],'compensation'=>$dataArray['compensation'],'description'=>$dataArray['description'],'entry_date'=>$CURRENT_DATE,'pikup_service_type'=>$dataArray['pikup_service_type'],
		 'service_type'=>$dataArray['service_type'],'prienter_required'=>$dataArray['prienter_required'],'start_weight_range'=>$dataArray['start_weight_range'],
		 'end_weight_range'=>$dataArray['end_weight_range']); 
		 
         $res_data=$this->ProductType_model->InsertProduct($productArray);   
		 
		 echo json_encode($res_data);
		 
	
	 }
	 
	   public function geteditProductData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true); 
		$table_id=$_POST['prid'];
		
		$returnArray=$this->ProductType_model->Getproductlist_edit($table_id);  
	
		 echo json_encode($returnArray);
	}
	 
	 public function EditForm_Update()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);  
		 $dataArray=$_POST['edit_product']; 
		 $prid=$dataArray['prid'];
		// $CURRENT_DATE=date("Y-m-d");
		 $editproductArray=array('title'=>$dataArray['title'],'dimesion_weight'=>$dataArray['dimesion_weight'],'dimesion_height'=>$dataArray['dimesion_height'],'dimesion_width'=>$dataArray['dimesion_width']
		 ,'dimesion_girth'=>$dataArray['dimesion_girth'],'pickupcharge'=>$dataArray['pickupcharge'],'from_time'=>$dataArray['from_time']
		 ,'to_time'=>$dataArray['to_time'],'compensation'=>$dataArray['compensation'],'description'=>$dataArray['description']);
		 
         $res_data=$this->ProductType_model->EditFormQuery($editproductArray,$prid);  
		 
		 echo json_encode($res_data);
		 
	
	 }
}
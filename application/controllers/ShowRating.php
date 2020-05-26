<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ShowRating extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('ShowRating_model');
    }
public function showrating()
{
$this->load->view('showrating/showrating');
}
public function ShowratingData() 
{
	 $_POST = json_decode(file_get_contents('php://input'), true);
	
	$returnArray=$this->ShowRating_model->getShowratingData($_POST);   
	$maniarray=$returnArray['result'];
	$dataArray['adata']=$_POST ;  
		foreach($maniarray as $key=>$val)
			{
				$maniarray[$key]['driver_id']=getsupplierbyid($maniarray[$key]['driver_id']);	 
			}    
		$resultArray=$maniarray;           
        $dataArray['result']=$resultArray;     
        $dataArray['count']=$returnArray['count'];  
		echo json_encode($dataArray);
     
	}
	
	public function showDriverDrop()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->ShowRating_model->GetDriverDropData($_POST); 
		
		echo json_encode($returnArray);
    }
}
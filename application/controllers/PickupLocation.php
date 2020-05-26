<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class PickupLocation extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
       $this->load->model('PickupLocation_model');
    }
public function showPickuploclist()
	    {
			$_POST = json_decode(file_get_contents('php://input'), true);
		    $returnArray=$this->PickupLocation_model->getShowPickuplist($_POST['searchfield'],$_POST['page_no']); 
			$maniarray=$returnArray['result'];
			 $dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$returnArray['count'];
			echo json_encode($dataArray);
	    }



}